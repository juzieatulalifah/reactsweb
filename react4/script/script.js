
document.addEventListener('DOMContentLoaded', function() {
    let currentFieldset = 0;
    const fieldsets = document.querySelectorAll('#msform fieldset');
    const nextButtons = document.querySelectorAll('.next');
    const prevButtons = document.querySelectorAll('.previous');
    
    function showFieldset(index) {
        fieldsets.forEach((fieldset, idx) => {
            if (idx === index) {
                fieldset.style.display = 'block';
            } else {
                fieldset.style.display = 'none';
            }
        });
        updateProgressBar(index);
    }
    
    function updateProgressBar(index) {
        const progressBarItems = document.querySelectorAll('#progressbar li');
        progressBarItems.forEach((item, idx) => {
            if (idx <= index) {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
            }
        });
    }
    
    nextButtons.forEach(button => {
        button.addEventListener('click', function() {
            if (currentFieldset < fieldsets.length - 1) {
                currentFieldset++;
                showFieldset(currentFieldset);
            }
        });
    });
    
    prevButtons.forEach(button => {
        button.addEventListener('click', function() {
            if (currentFieldset > 0) {
                currentFieldset--;
                showFieldset(currentFieldset);
            }
        });
    });
    
    // Show the first fieldset when the page loads
    showFieldset(currentFieldset);
});


document.querySelectorAll('.toggle-dropdown').forEach(button => {
    button.addEventListener('click', function() {
        const dropdown = this.nextElementSibling;
        if (dropdown && dropdown.classList.contains('dropdown')) {
            dropdown.style.maxHeight = dropdown.style.maxHeight ? null : dropdown.scrollHeight + 'px';
            this.classList.toggle('active');
        } else {
            console.error('Dropdown element not found or misplaced!');
        }
    });
});



document.querySelectorAll('.faq-item').forEach(item => {
    item.querySelector('.question').addEventListener('click', () => {
        const answer = item.querySelector('.answer');
        const icon = item.querySelector('.question span');

        document.querySelectorAll('.faq-item').forEach(otherItem => {
            if (otherItem !== item) {
                otherItem.querySelector('.answer').style.display = 'none';
                otherItem.querySelector('.question span').innerHTML = '&#9662;';
                otherItem.classList.remove('active');
            }
        });

        if (answer.style.display === 'block') {
            answer.style.display = 'none';
            icon.innerHTML = '&#9662;';
        } else {
            answer.style.display = 'block';
            icon.innerHTML = '&#9652;';
        }
    });
});




