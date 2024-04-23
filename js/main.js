// //faq accordion
document.addEventListener('DOMContentLoaded',()=>{
    const faqContainer=document.querySelector('.faq-content ');

    faqContainer.addEventListener('click' , (e)=> {
       const groupHeader=e.target.closest('.faq-group-header');
        if(!groupHeader) return;

       const group=groupHeader.parentElement;
       const groupBody=group.querySelector('.faq-group-body');
       const icon=groupHeader.querySelector('i');

       //toogle icon
       icon.classList.toggle('fa-plus');
       icon.classList.toggle('fa-minus');

       // toggle visibility of  body
       groupBody.classList.toggle('open');
        
       //close other open faq bodies
       const otherGroups=faqContainer.querySelectorAll('.faq-group');

       otherGroups.forEach((otherGroup)=>{
        if(otherGroup !== group){
            const otherGroupBody=otherGroup.querySelector('.faq-group-body');
            const otherIcon=otherGroup.querySelector('.faq-group-header i');

            otherGroupBody.classList.remove('open');
            otherIcon.classList.remove('fa-minus');
            otherIcon.classList.add('fa-plus');
        }

       });

    });
});
//moblie menu
document.addEventListener('DOMContentLoaded',()=>{
    const hamburgerButton=document.querySelector('.hamburger-button');
    const moblieMenu=document.querySelector('.mobile-menu');
    hamburgerButton.addEventListener('click',()=> moblieMenu.classList.toggle('active')
    );
})


// user menu
let menu= document.querySelector('#menu-btn');
let header=document.querySelector('.user-header');

menu.onclick = () =>{
    menu.classList.toggle('fa-times');
    header.classList.toggle('active');
    document.body.classList.toggle('active');

}


// window.onscroll = () =>{
//     if(window.innerWidth < 991){
//         menu.classList.remove('fa-times');
//         header.classList.remove('active');
//         document.body.classList.remove('active');
//     }
// }

function addInput(section) {
    var container = document.getElementById(section);
    var input = document.createElement("textarea");
    input.name = section + "[]";
    input.placeholder = "Enter your " + section.slice(0, -1);
    input.rows = "3";
    input.cols = "30";
    container.appendChild(input);
    container.appendChild(document.createElement("br"));
}