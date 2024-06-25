// Toggle admin menu tabs
function openTab(evt, tabName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tab-content");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("nav-tab");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" nav-tab-active", "");
    }
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " nav-tab-active";
}

// Toggle automaticaly admin menu tabs
document.addEventListener('DOMContentLoaded', function() {
    const params = new URLSearchParams(window.location.search);
    const tab = params.get('tab') || 'origins';
    document.querySelectorAll('.nav-tab').forEach(tabLink => {
        if (tabLink.href.includes(`tab=${tab}`)) {
            tabLink.className += ' nav-tab-active';
            document.getElementById(tab).style.display = 'block';
        } else {
            tabLink.className = tabLink.className.replace(' nav-tab-active', '');
            document.getElementById(tabLink.href.split('tab=')[1]).style.display = 'none';
        }
    });
});
