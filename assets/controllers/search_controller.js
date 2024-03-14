import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['searchBtn']

    openSearchPage(){
        const btn = this.searchBtnTarget;
        console.log(btn)
        btn.addEventListener('click', function (){
            window.location='/search';
        });
    }
}
