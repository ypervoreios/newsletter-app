import ClassicEditor from "@ckeditor/ckeditor5-build-classic";

const editorElement = document.querySelector("#content");

if (editorElement) {
    ClassicEditor.create(editorElement)
        .then((editor) => {
            console.log("CKEditor loaded");
        })
        .catch((error) => {
            console.error(error);
        });
}
