import {Controller} from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ["modal", 'input'];


    connect() {
        document.addEventListener('selectedImage', (event) => {
            const image = event.detail.image;
            this.loadImage(image);
        })
    }

    open() {
        this.modalTarget.hidden = false;
    }

    close() {
        this.modalTarget.hidden = true;
    }

    loadImage(name) {
        this.inputTarget.value = name;
        this.close();
    }
}
