const addPostBtn = document.querySelector(".add-post");
const form = document.querySelector(".post-form");
const formContainer = document.querySelector(".form-container");
const favouritePosts = document.querySelector(".favourite-posts-container");
const closePostBtn = document.querySelector(".close-adding-btn");

addPostBtn.addEventListener("click", function() {
    addPostBtn.classList.add("hidden");
    form.classList.remove("hidden");
    formContainer.classList.remove("hidden");
    if(!favouritePosts.classList.contains("hidden")) favouritePosts.classList.add("hidden"); 
});

closePostBtn.addEventListener("click", function() {
    addPostBtn.classList.remove("hidden");
    form.classList.add("hidden");
    formContainer.classList.add("hidden");
});


const openFavouritesBtn = document.querySelector(".favourites-btn");

openFavouritesBtn.addEventListener("click", function() {
    favouritePosts.classList.toggle("hidden");
});
