var sideBarIsOpen = true;


toggleBtn.addEventListener( 'click',  (event) =>{
    event.preventDefault();

    if(sideBarIsOpen){
    dashboard_sidebar.style.width = '5%';
    dashboard_sidebar.style.transition = '0.7s all'
    dashboard_content_container.style.width = '98%';
    dashboard_logo.style.fontSize = '11px';
    userImage.style.width = '25px';
    userImage.style.marginBottom = '10px';
    dashboard_logo.style.transition = '1.2s all'
    userImage.style.transition = '1.2s all'

    menuIcons = document.getElementsByClassName('menuText')
    for(var i=0; i < menuIcons.length; i++){
        menuIcons[i].style.display = 'none';
    }
    document.getElementsByClassName('dashboard_menu_lists')[0].style.textAlign = 'center';
    sideBarIsOpen = false;
}else{
    dashboard_sidebar.style.width = '280px';
    dashboard_content_container.style.width = '98%';
    dashboard_logo.style.fontSize = '25px';
    userImage.style.width = '60px';
    dashboard_logo.style.transition = '1.2s all'
    userImage.style.transition = '1.2s all'

    menuIcons = document.getElementsByClassName('menuText')
    for(var i=0; i < menuIcons.length; i++){
        menuIcons[i].style.display = 'inline-block';
    }

    document.getElementsByClassName('dashboard_menu_lists')[0].style.textAlign = 'left';
    sideBarIsOpen = true;
}
});

//Submenu show/hide function.

document.addEventListener('click', function(e){
    let clickedE1 = e.target;

    if(clickedE1.classList.contains('showHideSubMenu')){
        let subMenu =  clickedE1.closest('li').querySelector('.subMenus');
        let mainMenuIcon =  clickedE1.closest('li').querySelector('.mainMenuIconArrow');

        // Close all submenus.
        
        let subMenus = document.querySelectorAll('.subMenus');
        subMenus.forEach((sub) => {
            if(subMenu !== sub) sub.style.display = 'none';
        });


        // Call function to hide/show submenu.
        showHideSubMenu(subMenu,mainMenuIcon);

        
    }

});

// Function - to show/hide submenu.
function showHideSubMenu(subMenu,mainMenuIcon){

    // check if there is submenu
    if(subMenu != null){
            
        if(subMenu.style.display === 'block') {
            subMenu.style.display = 'none';
            mainMenuIcon.classList.remove('fa-angle-down');
            mainMenuIcon.classList.add('fa-angle-left');
            
        } else {
            subMenu.style.display = 'block';
            mainMenuIcon.classList.remove('fa-angle-left');
            mainMenuIcon.classList.add('fa-angle-down');
            
        }
      
    } 

}

// Add / hide active class to menu
// Get the current page
// Use selector to get the current menu or submenu
// Add the active class



let pathArray = window.location.pathname.split( '/' );
let curFile = pathArray[pathArray.length - 1];

let  curNav = document.querySelector('a[href="./' + curFile  + '"]');
curNav.classList.add('subMenuActive');

let mainNav = curNav.closest('li.liMainMenu')
mainNav.style.background ='#00ADB5';
 
let subMenu = curNav.closest('.subMenus'); 
let mainMenuIcon =  mainNav.querySelector('i.mainMenuIconArrow');

 // Call function to hide/show submenu.
 showHideSubMenu(subMenu,mainMenuIcon);







 