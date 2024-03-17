import {Controller} from '@hotwired/stimulus';

export default class extends Controller {

    connect() {
        this.hideAfterDelay();
    }

    hideAfterDelay() {
        setTimeout(() => {
            this.element.classList.add('opacity-0');
            setTimeout(() => this.element.remove(), 1000);
        }, 3000);

    }

}
