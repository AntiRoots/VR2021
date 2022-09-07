let modal;
let modalImg;
let captionText;
let photoId;
let photoDir="../upload_photos_normal/";

window.onload =function(){
    modal=document.getElementById("modalarea");
    modalImg = document.getElementById("modalimg");
    captionText=document.getElementById("modalcaption");

    let allTuhumbs=document.getElementById("gallery").getElementsByTagName("img");
    for (let i=0; i<allTuhumbs.length; i++)
    {
        allTuhumbs[i].addEventListener("click",openModal);
    }
    document.getElementById("modalclose").addEventListener("clic", closeModal);


}

function openModal(e)
{
    modalImg.src= photoDir + e.target.dataset.fn;
    photoId=e.target.dataset.id;
    captionText.innerHTML = e.target.alt;

    document.getElementsById("avgRating").innerHTML="";
    for(let i=1; i<6; i++){
        document.getElementsById("rate"+i).check =false;
    }
    document.getElementsById("storeRating").addEventListener("click", storeRating);
    modal.style.display="block";
}
function closeModal()
{
    document.getElementById("modalclose").removeEventListener("clic", closeModal);
    document.getElementsById("storeRating").removeEventListener("click", storeRating);
    modal.style.display="none";
    modalImg.src = "../images/empty.png";
}

function storeRating()
{
    let rating = 0;
    for(let i=1; i<6; i++){
        if(document.getElementsByID("rate"+i).checked){
            rating=i;
        }
        if(rating>0){
            //AJAX
            let webRequest =new XMLHttpRequest();
            webRequest.onreadystatechange=function(){
                //kas õnnestus
                if(this.readyState == 4 && this.status == 200){
                    //mida teeme, kui õnnestus
                    document.getElementsById("avgRating").innerHTML="Keskmine hinne: " + this.responseText;
                }
            };
            webRequest.open("GET","store_photorating.php?rating="+rating+"&photoid"+photoId, true);
            webRequest.send();
            //AJAX lõppeb
        }
    }
}