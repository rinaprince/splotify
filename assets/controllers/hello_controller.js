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
        console.log('Stimulus connected');
    }

    like(event) {
        event.preventDefault();
        const url = this.element.querySelector('a').getAttribute('href');

        fetch(url, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.toggleButton(true);
                    alert('Has fet like');
                } else {
                    alert('Error al donar like');
                }
            })
            .catch(error => {
                console.error('Error al donar like:', error);
                alert('Error al processar la solicitud');
            });
    }

    dislike(event) {
        event.preventDefault();
        const url = this.element.querySelector('a').getAttribute('href');

        fetch(url, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.toggleButton(false);
                    alert('Has donat dislike');
                } else {
                    alert('Error al donar dislike');
                }
            })
            .catch(error => {
                console.error('Error al donar dislike:', error);
                alert('Error al processar la solicitud');
            });
    }

    toggleButton(liked) {
        const button = this.element.querySelector('button');
        button.classList.remove('btn-warning', 'btn-danger');
        button.innerHTML = '';

        if (liked) {
            button.classList.add('btn-danger');
            button.innerHTML = '<i class="bi bi-star-half"></i>';
            button.dataset.action = 'click->hello#dislike';
        } else {
            button.classList.add('btn-warning');
            button.innerHTML = '<i class="bi bi-star"></i>';
            button.dataset.action = 'click->hello#like';
        }
    }
}
