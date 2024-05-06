import { Controller } from '@hotwired/stimulus';

/*
 * This is an example Stimulus controller!
 *
 * Any element with a data-controller="hello" attribute will cause
 * this controller to be executed. The name "hello" comes from the filename:
 * hello_controller.js -> "hello"
 *
 * Delete this file or adapt it for your use!
 */
export default class extends Controller {
    connect() {
        //this.element.textContent = 'Hello Stimulus! Edit me in assets/controllers/hello_controller.js';
    }

    static targets = ["button"]

    like(event) {
        event.preventDefault();
        alert('Has fet like');
        this.toggleButton(true);
    }

    dislike(event) {
        event.preventDefault();
        alert('Has fet dislike');
        this.toggleButton(false);
    }

    toggleButton(liked) {
        const button = this.element.querySelector('button');
        button.classList.remove('btn-warning', 'btn-danger');
        button.innerHTML = '';

        if (liked) {
            button.classList.add('btn-danger');
            button.innerHTML = '<i class="bi bi-star-half"></i>';
            button.dataset.action = 'hello#dislike';
        } else {
            button.classList.add('btn-warning');
            button.innerHTML = '<i class="bi bi-star"></i>';
            button.dataset.action = 'hello#like';
        }
    }
}
