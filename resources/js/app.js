import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

const button = document.getElementById('bankButton');
const list = document.getElementById('bankList');
const selected = document.getElementById('selectedBank');
const input = document.getElementById('bankInput');


if (button && list && selected && input) {

    button.addEventListener('click', () => {
        list.classList.toggle('hidden');
    });


    document.querySelectorAll('.bank-option').forEach(option => {

        option.addEventListener('click', () => {

            const value = option.dataset.value;

            selected.textContent = value;
            input.value = value;

            // effet sélectionné
            document.querySelectorAll('.bank-option')
                .forEach(item => {
                    item.classList.remove(
                        'border-teal-600',
                        'bg-teal-50',
                        'ring-2',
                        'ring-teal-500'
                    );
                });

            option.classList.add(
                'border-teal-600',
                'bg-teal-50',
                'ring-2',
                'ring-teal-500'
            );


            list.classList.add('hidden');

        });

    });

}

