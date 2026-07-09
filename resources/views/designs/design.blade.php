<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <!-- Ensure proper scaling on mobile devices -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $design->name  }}</title>
  <!-- CSRF Token for AJAX requests -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- External Libraries -->
  <!-- html2canvas for capturing the design -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
  <!-- Alpine.js for reactive UI -->
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js" defer></script>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" crossorigin="anonymous" />
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
  <!-- Font Awesome (optional) -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" crossorigin="anonymous" />

  <style>
    /* Global Styles */
    body {
      font-family: 'Roboto', sans-serif;
      background: #f8f9fa;
      margin: 0;
      padding: 0;
    }
    header {
      background: #fff;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
      margin-bottom: 20px;
    }
    .card {
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      margin-bottom: 20px;
    }
    .preview-card, .controls-card {
      padding: 20px;
    }
    /* T-Shirt Preview Styles */
    .tshirt-container {
      position: relative;
      width: 100%;
      border: 1px solid #e0e0e0;
      border-radius: 8px;
      overflow: hidden;
      background: #fafafa;
    }
    .tshirt-container img {
      width: 100%;
      display: block;
    }
    .design-overlay {
      position: absolute;
      transform: translate(-50%, -50%);
      pointer-events: auto;
      user-select: none;
    }
    .design-overlay.dragging {
      cursor: grabbing;
    }
    /* Form Controls */
    .form-group {
      margin-bottom: 15px;
    }
    .form-group label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }
    .form-control {
      width: 100%;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    /* Buttons */
    button {
      border: none;
      border-radius: 4px;
      padding: 12px 20px;
      font-size: 16px;
      cursor: pointer;
      transition: background 0.3s;
    }
    .preview-btn, .save-btn {
      background: #f4511e;
      width: 100%;
      margin-top: 10px;
      color: #fff;
    }
    .preview-btn:hover, .save-btn:hover {
      background: #d84315;
    }
    @media (max-width: 768px) {
      .row {
        flex-direction: column;
      }
    }
  </style>
</head>
<body>
  <header class="text-center py-4">
    <h1>{{ $design->name }}</h1>
  </header>

  <main class="container" x-data="dragDesign()" x-on:mousemove.window="drag($event)" x-on:mouseup.window="endDrag()">
    <div class="row">
      <!-- T-Shirt Preview Section -->
      <section class="col-md-6">
        <div class="card preview-card">
          <div class="tshirt-container" x-ref="container">
            <!-- Model Image -->
            <img src="{{ asset('assets/design/model.jpg') }}" alt="Model wearing a T-Shirt" crossorigin="anonymous" />
            <!-- Draggable Text Overlay -->
            <div
              class="design-overlay"
              :class="{ dragging: currentDrag === 'text' }"
              x-on:mousedown="startDragText($event)"
              :style="`top: ${textY}px; left: ${textX}px; color: ${textColor}; font-size: ${fontSize}px;`"
              aria-label="Draggable Text"
            >
              <span x-text="text"></span>
            </div>
            <!-- Draggable Image Overlay -->
            <template x-if="imageUrl">
              <div
                class="design-overlay"
                :class="{ dragging: currentDrag === 'image' }"
                x-on:mousedown="startDragImage($event)"
                :style="`top: ${imageY}px; left: ${imageX}px;`"
                aria-label="Draggable Design Image"
              >
                <img
                  :src="imageUrl"
                  alt="Uploaded Design"
                  style="max-width: 100px; max-height: 100px;"
                  crossorigin="anonymous"
                />
              </div>
            </template>
          </div>
          <!-- Save Product Button -->
          <button class="save-btn mt-3" type="button" @click="saveProduct()" aria-label="Save Product">Save Design</button>
        </div>
      </section>

      <!-- Controls Section -->
      <section class="col-md-6">
        <div class="card controls-card">
          <form>
            <div class="form-group">
              <label for="tshirtText">T-Shirt Text:</label>
              <input type="text" id="tshirtText" x-model="text" class="form-control" placeholder="Enter your text" aria-label="T-Shirt Text" />
            </div>
            <div class="form-group">
              <label for="textColor">Text Color:</label>
              <input type="color" id="textColor" x-model="textColor" class="form-control" aria-label="Text Color" />
            </div>
            <div class="form-group">
              <label for="fontSize">
                Font Size: <span x-text="fontSize"></span>px
              </label>
              <input type="range" id="fontSize" min="12" max="48" x-model="fontSize" class="form-control" aria-label="Font Size" />
            </div>
            <div class="form-group">
              <label for="imageUpload">Upload Image:</label>
              <input type="file" id="imageUpload" @change="handleImageUpload($event)" accept="image/*" class="form-control" aria-label="Upload Image" />
            </div>
          </form>
        </div>
      </section>
    </div>
  </main>

  <script>
    function dragDesign() {
      return {
        // Design properties
        text: "Your Design",
        textColor: "#000000",
        fontSize: 24,
        textX: 175,
        textY: 200,
        imageUrl: null,
        imageX: 175,
        imageY: 250,

        // Drag state
        currentDrag: null,
        offsetX: 0,
        offsetY: 0,

        /**
         * Initiate dragging for the text overlay.
         */
        startDragText(e) {
          this.currentDrag = "text";
          e.preventDefault();
          const textRect = e.target.getBoundingClientRect();
          this.offsetX = e.clientX - textRect.left;
          this.offsetY = e.clientY - textRect.top;
        },

        /**
         * Initiate dragging for the image overlay.
         */
        startDragImage(e) {
          this.currentDrag = "image";
          e.preventDefault();
          const imageRect = e.target.getBoundingClientRect();
          this.offsetX = e.clientX - imageRect.left;
          this.offsetY = e.clientY - imageRect.top;
        },

        /**
         * Update the position of the draggable element during mouse move.
         */
        drag(e) {
          if (!this.currentDrag) return;

          const containerRect = this.$refs.container.getBoundingClientRect();
          let newX = e.clientX - containerRect.left - this.offsetX;
          let newY = e.clientY - containerRect.top - this.offsetY;

          // Constrain movement within container boundaries
          newX = Math.max(0, Math.min(newX, containerRect.width));
          newY = Math.max(0, Math.min(newY, containerRect.height));

          if (this.currentDrag === "text") {
            this.textX = newX;
            this.textY = newY;
          } else if (this.currentDrag === "image") {
            this.imageX = newX;
            this.imageY = newY;
          }
        },

        /**
         * End the dragging action.
         */
        endDrag() {
          this.currentDrag = null;
        },

        /**
         * Handle image file upload using FileReader.
         */
        handleImageUpload(e) {
          const file = e.target.files[0];
          if (!file) return;
          if (!file.type.startsWith('image/')) {
            alert('Please upload a valid image file.');
            return;
          }
          const reader = new FileReader();
          reader.onload = (event) => {
            this.imageUrl = event.target.result;
          };
          reader.onerror = (error) => {
            console.error('Error reading file:', error);
            alert('An error occurred while reading the file.');
          };
          reader.readAsDataURL(file);
        },

        /**
         * Capture the design as a PNG using html2canvas and send it to the backend.
         */
        saveProduct() {
          html2canvas(this.$refs.container, { useCORS: true })
            .then(canvas => {
              const dataUrl = canvas.toDataURL("image/png");
              fetch("{{ url('product/preview') }}", {
                method: "POST",
                headers: {
                  "Content-Type": "application/json",
                  "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                },
                body: JSON.stringify({
                  image: dataUrl,
                  text: this.text,
                  textColor: this.textColor,
                  fontSize: this.fontSize,
                }),
              })
              .then(response => response.json())
              .then(data => {
                if (data.success) {
                  alert("Product saved successfully!");
                  window.location.href = data.redirect_url;
                } else {
                  alert("Error saving product.");
                }
              })
              .catch(error => {
                console.error("Error saving product:", error);
                alert("An error occurred while saving the product.");
              });
            })
            .catch(error => {
              console.error("Error capturing design:", error);
            });
        },
      };
    }
  </script>
</body>
</html>
