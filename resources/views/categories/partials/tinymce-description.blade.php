<script src="https://cdn.jsdelivr.net/npm/tinymce@6.4.2/tinymce.min.js"></script>
<script>
    const categoryImageUploadUrl = @json(route('categories.upload-image'));
    const categoryCsrfToken = @json(csrf_token());

    function uploadCategoryEditorImage(blobInfo, progress) {
        return new Promise((resolve, reject) => {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', categoryImageUploadUrl);
            xhr.setRequestHeader('X-CSRF-TOKEN', categoryCsrfToken);

            xhr.upload.onprogress = (event) => {
                if (event.lengthComputable) {
                    progress(event.loaded / event.total * 100);
                }
            };

            xhr.onload = () => {
                let response;

                try {
                    response = JSON.parse(xhr.responseText);
                } catch (error) {
                    reject({ message: 'Invalid upload response.', remove: true });
                    return;
                }

                if (xhr.status < 200 || xhr.status >= 300) {
                    reject({ message: response.message || 'Image upload failed.', remove: true });
                    return;
                }

                if (!response || typeof response.location !== 'string') {
                    reject({ message: 'Upload response did not include an image URL.', remove: true });
                    return;
                }

                resolve(response.location);
            };

            xhr.onerror = () => reject({ message: 'Image upload failed due to a network error.', remove: true });

            const formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());
            xhr.send(formData);
        });
    }

    function waitForCategoryEditorUploads() {
        const form = document.querySelector('[data-tinymce-upload-form]');

        if (!form) {
            return;
        }

        let isSubmitting = false;

        form.addEventListener('submit', function (event) {
            if (isSubmitting) {
                return;
            }

            const editor = tinymce.get('description');

            if (!editor) {
                return;
            }

            event.preventDefault();

            const submitButton = form.querySelector('[type="submit"]');
            const originalButtonHtml = submitButton ? submitButton.innerHTML : '';

            if (submitButton) {
                submitButton.disabled = true;
                submitButton.innerHTML = 'Saving...';
            }

            editor.uploadImages()
                .then(() => {
                    editor.save();
                    isSubmitting = true;
                    form.submit();
                })
                .catch(() => {
                    if (submitButton) {
                        submitButton.disabled = false;
                        submitButton.innerHTML = originalButtonHtml;
                    }

                    alert('One or more images could not be uploaded. Please try again.');
                });
        });
    }

    tinymce.init({
        selector: '#description',
        plugins: 'image link lists media table code wordcount fullscreen',
        toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | link image media | code fullscreen',
        menubar: 'file edit view insert format tools table help',
        height: 500,
        branding: false,
        file_picker_types: 'image',
        automatic_uploads: true,
        images_upload_handler: uploadCategoryEditorImage,
        convert_urls: false,
        image_title: true,
        promotion: false,
        file_picker_callback: function (cb) {
            const input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');
            input.onchange = function () {
                const file = this.files[0];
                const reader = new FileReader();
                reader.onload = function () {
                    const id = 'blobid' + (new Date()).getTime();
                    const blobCache = tinymce.activeEditor.editorUpload.blobCache;
                    const base64 = reader.result.split(',')[1];
                    const blobInfo = blobCache.create(id, file, base64);
                    blobCache.add(blobInfo);
                    cb(blobInfo.blobUri(), { title: file.name });
                };
                reader.readAsDataURL(file);
            };
            input.click();
        },
    });

    document.addEventListener('DOMContentLoaded', waitForCategoryEditorUploads);
</script>
