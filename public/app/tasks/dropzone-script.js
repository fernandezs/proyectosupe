Dropzone.options.myDropzone = {
    autoProcessQueue: false,
    uploadMultiple: true,
    maxFilezise: 10,
    maxFiles: 2,
    clickable: true,
    addRemoveLinks: true,
    createImageThumbnails: true,
    acceptedFiles: 'image/*,application/pdf',

    init: function() {
        var submitBtn = document.querySelector("#submit");
        myDropzone = this;

        submitBtn.addEventListener("click", function(e){
            e.preventDefault();
            e.stopPropagation();
            myDropzone.processQueue();
            location.reload();
        });

        this.on("addedfile", function(file) {
             
        });

        this.on("complete", function(file) {
            
            myDropzone.removeFile(file);
        });

        this.on("success",
            myDropzone.processQueue.bind(myDropzone)
        );
    }
};