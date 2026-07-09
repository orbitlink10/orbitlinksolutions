@extends('theme.lucare.layouts.main')
@section('title') Contact with us @endsection
@section('main')


    <!-- html2canvas -->
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"
      integrity="sha512-BNaIt7gJSBXJ+bOLhw5P8AG84D6YbJXHWMt+mS66ifweXoH3qL6kgE99z+8sklmHvI27rL8aXK/4JkpPUbXwKQ=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    ></script>

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js" defer></script>

    <!-- Google Fonts -->
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap"
      rel="stylesheet"
    />

    <style>
      /* Global Styles */
      body {
        font-family: "Roboto", sans-serif;
        margin: 0;
        padding: 0;
        background: #f4f7f6;
        color: #333;
      }
      header {
        background: #1e88e5;
        color: #fff;
        padding: 1rem 0;
        text-align: center;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      }
      h1 {
        margin: 0;
        font-size: 2rem;
      }
      /* Container Layout */
      .container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        padding: 20px;
      }
      .card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin: 20px;
        overflow: hidden;
      }
      .preview-card {
        width: 350px;
        position: relative;
        padding: 20px;
      }
      .controls-card {
        width: 350px;
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
      .form-group input[type="text"],
      .form-group input[type="color"],
      .form-group input[type="range"],
      .form-group input[type="file"] {
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
      .preview-btn {
        background: #f4511e;
        width: 100%;
        margin-top: 10px;
        color: #fff;
      }
      .preview-btn:hover {
        background: #d84315;
      }
    </style>
 
    <header>
      <h1>T-Shirt Designer</h1>
    </header>
    <div
      class="container"
      x-data="dragDesign()"
      x-on:mousemove.window="drag($event)"
      x-on:mouseup.window="endDrag()"
    >
      <!-- Preview Card -->
      <div class="card preview-card">
        <div class="tshirt-container" x-ref="container">
          <!-- Model image (ensure CORS is enabled) -->
          <img src="{{ asset('assets/design/model.jpg') }}" alt="Person wearing a T-Shirt" crossorigin="anonymous" />
          <!-- Draggable Text Overlay -->
          <div
            class="design-overlay"
            :class="{ dragging: currentDrag === 'text' }"
            x-on:mousedown="startDragText($event)"
            :style="`top: ${textY}px; left: ${textX}px; color: ${textColor}; font-size: ${fontSize}px;`"
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
        <!-- Preview Button -->
        <button class="preview-btn" type="button" @click="previewDesign()">
          Preview Product
        </button>

        <!-- Product Preview -->
        <div x-show="productPreview">
          <h3>Product Preview:</h3>
          <div>
            <img :src="previewImageUrl" alt="Previewed Product" style="width: 100%; max-width: 350px;" />
          </div>
        </div>
      </div>
      <!-- Controls Card -->
      <div class="card controls-card">
        <form>
          <div class="form-group">
            <label for="tshirtText">T-Shirt Text:</label>
            <input
              type="text"
              id="tshirtText"
              x-model="text"
              placeholder="Enter your text"
            />
          </div>
          <div class="form-group">
            <label for="textColor">Text Color:</label>
            <input type="color" id="textColor" x-model="textColor" />
          </div>
          <div class="form-group">
            <label for="fontSize">
              Font Size: <span x-text="fontSize"></span>px
            </label>
            <input type="range" id="fontSize" min="12" max="48" x-model="fontSize" />
          </div>
          <div class="form-group">
            <label for="imageUpload">Upload Image:</label>
            <input
              type="file"
              id="imageUpload"
              @change="handleImageUpload($event)"
              accept="image/*"
            />
          </div>
        </form>
      </div>
    </div>

    <script>
      function dragDesign() {
        return {
          // Text overlay state
          text: "Your Design",
          textColor: "#000000",
          fontSize: 24,
          // Center positions based on a 350px-wide preview card
          textX: 175,
          textY: 200,

          // Image overlay state
          imageUrl: null,
          imageX: 175,
          imageY: 250,

          // Product Preview state
          productPreview: false,
          previewImageUrl: "",

          // Drag state
          currentDrag: null, // 'text' or 'image'
          offsetX: 0,
          offsetY: 0,

          // Start dragging the text overlay
          startDragText(e) {
            this.currentDrag = "text";
            e.preventDefault();
            const rect = e.currentTarget.getBoundingClientRect();
            const centerX = rect.left + rect.width / 2;
            const centerY = rect.top + rect.height / 2;
            this.offsetX = e.clientX - centerX;
            this.offsetY = e.clientY - centerY;
          },

          // Start dragging the image overlay
          startDragImage(e) {
            this.currentDrag = "image";
            e.preventDefault();
            const rect = e.currentTarget.getBoundingClientRect();
            const centerX = rect.left + rect.width / 2;
            const centerY = rect.top + rect.height / 2;
            this.offsetX = e.clientX - centerX;
            this.offsetY = e.clientY - centerY;
          },

          // Handle dragging for the current overlay
          drag(e) {
            if (!this.currentDrag) return;
            const containerRect = this.$refs.container.getBoundingClientRect();
            let newX = e.clientX - containerRect.left - this.offsetX;
            let newY = e.clientY - containerRect.top - this.offsetY;
            if (this.currentDrag === "text") {
              this.textX = newX;
              this.textY = newY;
            } else if (this.currentDrag === "image") {
              this.imageX = newX;
              this.imageY = newY;
            }
          },

          // End dragging
          endDrag() {
            this.currentDrag = null;
          },

          // Handle image upload via FileReader
          handleImageUpload(e) {
            const file = e.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = (event) => {
              this.imageUrl = event.target.result;
            };
            reader.readAsDataURL(file);
          },

          // Preview the product design by sending data to the backend
          previewDesign() {
            html2canvas(this.$refs.container)
              .then((canvas) => {
                const dataURL = canvas.toDataURL("image/png");
                
                // Send the design data to the backend (Laravel)
                fetch("/product/preview", {
                  method: "POST",
                  headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                  },
                  body: JSON.stringify({
                    image: dataURL,
                    text: this.text,
                    textColor: this.textColor,
                    fontSize: this.fontSize
                  })
                })
                  .then(response => response.json())
                  .then(data => {
                    if (data.success) {
                      // Display product preview
                      this.productPreview = true;
                      this.previewImageUrl = data.product.image_url; // Return image URL from backend
                    } else {
                      alert("There was an error creating the product preview.");
                    }
                  })
                  .catch(error => {
                    console.error("Error:", error);
                    alert("An error occurred while creating the product preview.");
                  });
              })
              .catch(error => {
                console.error("Error capturing design:", error);
              });
          }
        };
      }
    </script>

@endsection
