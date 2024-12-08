document.getElementById('toggleSidebar').addEventListener('click', function() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('active');

    const icons = document.querySelectorAll('.fa-street-view, .fa-home, .fa-puzzle-piece, .fa-question, .fa-id-badge, .fa-info, .fa-angle-left');
    icons.forEach(icon => {
        icon.classList.toggle('hide-icons');
        icon.classList.toggle('hide-arrow');
    });

    const overlay = document.getElementById('overlay'); // Ensure overlay exists
    if (overlay) {
        if (sidebar.classList.contains('active')) {
            overlay.classList.add('active');
        } else {
            overlay.classList.remove('active');
        }
    }
});

// Toggle Sidebar with Hamburger Menu
document.getElementById('hamburgerMenu').addEventListener('click', function () {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('active');
});

// Optional: Close Sidebar When Clicking Outside
document.addEventListener('click', function (event) {
    const sidebar = document.getElementById('sidebar');
    const hamburger = document.getElementById('hamburgerMenu');
    if (!sidebar.contains(event.target) && !hamburger.contains(event.target)) {
        sidebar.classList.remove('active');
    }
});

/*tab links*/
function openAbout(evt, aboutnames) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(aboutnames).style.display = "block";
    if (evt) {
        evt.currentTarget.className += " active";
    } else {
        document.querySelector(`.tablinks[onclick*="${aboutnames}"]`).className += " active";
    }
}

window.onload = function() {
    const defaultTab = 'Mudah';
    openAbout(null, defaultTab);
};

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
/*tab links*/


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




