import {Controller} from '@hotwired/stimulus';

export default class extends Controller {

    static values = {
        image: String
    }


    selectImage() {
        console.log(this.imageValue);
        const selectedImageEvent = new CustomEvent('selectedImage', {
            detail: {
                image: this.imageValue,
            }
        });
        document.dispatchEvent(selectedImageEvent);
    }
}
