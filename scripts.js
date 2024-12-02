function toggleMenu() {
  const burgerMenu = document.getElementById("burger-menu");
  const navContainer = document.getElementById("navLinks");
  burgerMenu.classList.toggle("toggled"); // Animate burger menu
   // Show or hide the navigation container
  navContainer.classList.toggle("active"); 
}

let number = 8; // Total number of elements
let show = 6;   // Number of elements to show at a time
let moves = [
    [0, 1, 2, 3],
    [1, 2, 3, 4],
    [2, 3, 4, 5],
    [3, 4, 5, 6],
    [4, 5, 6, 7],
    [5, 6, 7, 0],
    [6, 7, 0, 1],
    [7, 0, 1, 2]
];
let move = 0;
let itemNumber = [5, 10, 3, 4, 8, 4, 4, 4]; // Items for each category
const recipeDetails = {
    "Chicken Adobo": {
        image: "/Recipe-Pages/recipePicture/ChickenAdobo.jpg",
        description: "A Filipino dish of chicken stewed in soy sauce, vinegar, and spices.",
        htmlPage: "/Chicken-Adobo.html"
    },
    "Chicken and Gravy": {
        image: "/Recipe-Pages/recipePicture/ChickenGravy.jpg",
        description: "Crispy fried chicken paired with rich and creamy gravy.",
        htmlPage: "/Chicken-Gravy.html"
    },
    "Tasty Mozarella Buns": { 
        image: "/Recipe-Pages/recipePicture/TastyMozarellaBuns.JPG",
        description: "Soft buns filled with gooey mozzarella cheese.",
        htmlPage: "/Tasty-Mozarella-Buns.html"
    },
    "Avocado Salad": { 
        image: "/Recipe-Pages/recipePicture/AvocadoSalad.jpg",
        description: "A fresh and creamy salad made with ripe avocados and greens.",
        htmlPage: "/Avocado-Salad.html"
    },
    "Mushroom Pizza with Black Olives": { 
        image: "/Recipe-Pages/recipePicture/MushroomPizza.jpg",
        description: "Thin crust pizza topped with mushrooms and black olives.",
        htmlPage: "/Mushroom-Pizza.html"
    },
    "Real American Hamburger": { 
        image: "/Recipe-Pages/recipePicture/RealAmericanHamburger.jpg",
        description: "A classic American burger with a juicy beef patty and fresh toppings.",
        htmlPage: "/Real-American-Hamburger.html"
    },
    "Lechon Kawali": { 
        image: "/Recipe-Pages/recipePicture/LechonKawali.jpg",
        description: "Crispy fried pork belly served with a savory dipping sauce.",
        htmlPage: "/Lechon-Kawali.html"
    },
    "Smash Cheeseburger": { 
        image: "/Recipe-Pages/recipePicture/SmashBurger.jpg",
        description: "A mouthwatering burger with a smashed beef patty and melted cheese.",
        htmlPage: "/Smash-Burger.html"
    },
    "Shrimp Sinigang": { 
        image: "/Recipe-Pages/recipePicture/ShrimpSinigang.jpg",
        description: "A sour Filipino soup with shrimp, tamarind, and fresh vegetables.",
        htmlPage: "/Shrimp-Sinigang.html"
    },
    "Kare-kare": { 
        image: "/Recipe-Pages/recipePicture/KareKare.jpg",
        description: "A traditional Filipino stew with peanut sauce and assorted meats.",
        htmlPage: "/Kare-kare.html"
    },
    "Italian Pasta": { 
        image: "/Recipe-Pages/recipePicture/ItalianPasta.jpg",
        description: "Classic pasta tossed in a rich and flavorful Italian sauce.",
        htmlPage: "/Italian-Pasta.html"
    },
    "Pork Sisig": { 
        image: "/Recipe-Pages/recipePicture/PorkSisig.jpg",
        description: "A sizzling Filipino dish made of chopped pork and savory seasonings.",
        htmlPage: "/Pork-Sisig.html"
    },
    "Tomato Salad": { 
        image: "/Recipe-Pages/recipePicture/TomatoSalad.jpg",
        description: "A refreshing salad featuring ripe tomatoes, onions, and olive oil.",
        htmlPage: "/Tomato-Salad.html"
    },
    "Filet Mignon": { 
        image: "/Recipe-Pages/recipePicture/FiletMignon.jpg",
        description: "Tender and juicy steak cooked to perfection.",
        htmlPage: "/Filet-Mignon.html"
    },
    "Creamy Mushroom Soup": { 
        image: "/Recipe-Pages/recipePicture/CreamyMushroomSoup.jpg",
        description: "A comforting soup with creamy mushrooms and herbs.",
        htmlPage: "/Creamy-Mushroom-Soup.html"
    },
    "Chicken Noodle Soup": { 
        image: "/Recipe-Pages/recipePicture/ChickenNoodleSoup.jpg",
        description: "A hearty soup with tender chicken, noodles, and vegetables.",
        htmlPage: "/Chicken-Noodle-Soup.html"
    },
    "Clam Chowder": { 
        image: "/Recipe-Pages/recipePicture/ClamChowder.jpg",
        description: "Rich and creamy soup with clams, potatoes, and celery.",
        htmlPage: "/Clam-Chowder.html"
    },
    "Greek Salad": { 
        image: "/Recipe-Pages/recipePicture/GreekSalad.jpg",
        description: "A vibrant salad with fresh cucumbers, tomatoes, olives, and feta cheese.",
        htmlPage: "/Greek-Salad.html"
    },
    "Caesar Salad": { 
        image: "/Recipe-Pages/recipePicture/CaesarSalad.jpg",
        description: "Crisp lettuce tossed in Caesar dressing with croutons and parmesan.",
        htmlPage: "/CaesarSalad.html"
    },
    "Classic Strawberry Shortcake": { 
        image: "/Recipe-Pages/recipePicture/ClassicStrawberryShortcake.jpg",
        description: "A delightful dessert with layers of sponge cake, strawberries, and cream.",
        htmlPage: "/Classic-Strawberry-Shortcake.html"
    },
    "Cassava Cake": { 
        image: "/Recipe-Pages/recipePicture/CassavaCake.jpg",
        description: "A Filipino dessert made from grated cassava and coconut milk.",
        htmlPage: "/CassavaCake.html"
    },
    "Banana with Chocolate Sauce": { 
        image: "/Recipe-Pages/recipePicture/BananawithChocolateSauce.jpg",
        description: "Sweet bananas drizzled with a rich chocolate sauce.",
        htmlPage: "/BananaWithChocolate.html"
    },
    "Cheesecake": { 
        image: "/Recipe-Pages/recipePicture/Cheesecake.jpg",
        description: "A smooth and creamy dessert with a graham cracker crust.",
        htmlPage: "/Cheese-Cake.html"
    }
};

// Image sources
const pictureSrc = ["/Recipe-Pages/Category-images/BREAKFAST.jpg", "/Recipe-Pages/Category-images/LUNCH.png", "/Recipe-Pages/Category-images/SNACKS.jpg", "/Recipe-Pages/Category-images/desserts_img.jpg", "/Recipe-Pages/Category-images/SmashBurger.jpg", "/Recipe-Pages/Category-images/ShrimpSinigang.jpg", "/Recipe-Pages/Category-images/Salad.jpg", "/Recipe-Pages/Category-images/Dinner.jpg"];
const categoryLabel = ["BREAKFAST", "LUNCH", "APPETIZER", "DESSERT", "MAIN DISH", "SOUP", "SALAD", "DINNER"];
let isNextGrid = false;
// Track the currently selected option
let selectedOptionIndex = null;
let itemNumberCategory = []; // To store the ranges for each category

let isNewCategory = false;
let recipeNames = [["Chicken Adobo", "Chicken and Gravy","Tasty Mozarella Buns","Avocado Salad", "Mushroom Pizza with Black Olives" ],
                        [   "Real American Hamburger", 
                            "Chicken Adobo", 
                            "Lechon Kawali", 
                            "Smash Cheeseburger", 
                            "Shrimp Sinigang", 
                            "Kare-kare", 
                            "Chicken and Gravy", 
                            "Italian Pasta", 
                            "Pork Sisig", 
                            "Mushroom Pizza with Black Olives"],
                        [   "Tasty Mozarella Buns", 
                            "Tomato Salad", 
                            "Avocado Salad"],
                        [   "Classic Strawberry Shortcake", 
                            "Cassava Cake", 
                            "Banana with Chocolate Sauce", 
                            "Cheesecake"],
                        [   "Filet Mignon",
                            "Chicken Adobo",
                            "Chicken and Gravy",
                            "Pork Sisig",
                            "Mushroom Pizza with Black Olives",
                            "Kare-kare",
                            "Smash Cheeseburger",
                            "Real American Hamburger"
                        ],
                        [
                            "Shrimp Sinigang",
                            "Creamy Mushroom Soup",
                            "Chicken Noodle Soup",
                            "Clam Chowder"
                        ],
                        [
                            "Tomato Salad",
                            "Avocado Salad",
                            "Greek Salad",
                            "Caesar Salad"
                        ],
                        [
                            "Filet Mignon",
                            "Italian Pasta",
                            "Tomato Salad",
                            "Avocado Salad"
                        ]
                    ];
document.addEventListener('DOMContentLoaded', function () {
    let optionContainer = document.querySelector(".options-container");

    // Dynamically create elements for categories
    for (let i = 0; i < number; i++) {
        let option = document.createElement("div");
        
        option.className = `option Option-${i + 1}`;
        option.style.backgroundImage = `url(${pictureSrc[i]})`;
        option.innerHTML = `<h5 class="jost-semibold-30">${categoryLabel[i]}</h5>`;
        option.dataset.index = i; // Store the index in a data attribute
        option.addEventListener("click", () => selectOption(option)); // Add click event
        optionContainer.appendChild(option);
    }

    // Create items and store ranges for categories
    createItem();
    
    // Initial display
    const urlParams = new URLSearchParams(window.location.search);
    const indexOfOption = urlParams.get('option');
    
    if(indexOfOption===null){
        updateDisplay();
    }
    else{
        selectedOptionHomePage(parseInt(indexOfOption));
    }
});

function createItem() {
    let container = document.querySelector(".recipes-grid-container");
    let itemStartIndex = 0;

    for (let i = 0; i < number; i++) {
        let itemCount = itemNumber[i];
        let endIndex = itemStartIndex + itemCount;

        itemNumberCategory[i] = { start: itemStartIndex, end: endIndex - 1 };

        // Ensure we're iterating within the bounds of the recipes array for each category
        let categoryRecipes = recipeNames[i]; // Get the recipes for this category
        for (let x = 0; x < itemCount; x++) {
            let item = document.createElement("div");
            item.className = "recipes-grid-item recipes";
            item.dataset.categoryIndex = i;

            // Get the correct recipe from the category
            let recipeName = categoryRecipes[x];
            let recipeData = recipeDetails[recipeName]; // Retrieve recipe data
            
            if (recipeData) {
                // Create anchor tag
                let link = document.createElement("a");
                link.href = `${recipeData.htmlPage}`;  // Update this to the actual link if needed
                link.className = `${recipeData.htmlPage}`;
                // Create image div
                let img = document.createElement("div");
                img.style.backgroundImage = `url(${recipeData.image})`;
                img.className = "recipes-grid-item-image";
                
                // Append the image div to the link
                link.appendChild(img);

                // Create text wrapper
                let textWrapper = document.createElement("div");
                textWrapper.className = "text-wrapper";
                

                // Add recipe name
                let recipeTitle = document.createElement("h2");
                recipeTitle.className = "recipe-title jost-normal";
                recipeTitle.textContent = recipeName;
                recipeTitle.style.textDecoration = "none";
                textWrapper.appendChild(recipeTitle);

                // Add recipe description
                let recipeDescription = document.createElement("p");
                recipeDescription.className = "recipe-description jost-normal";
                recipeDescription.textContent = recipeData.description;
                textWrapper.appendChild(recipeDescription);

                // Append the text wrapper to the link (not directly to item)
                link.appendChild(textWrapper);

                // Append the entire link (image + text) to the item
                item.appendChild(link);
            } else {
                console.error(`Recipe details not found for: ${recipeName}`);
            }

            // Append the item to the container
            container.appendChild(item);
        }

        itemStartIndex = endIndex; // Update itemStartIndex for next category
    }
}

// Helper function to capitalize the first letter
function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function updateDisplay() {
    let options = document.querySelectorAll(".option");
    let items = document.querySelectorAll(".recipes-grid-item");

    // Hide all options
    options.forEach((option) => {
        option.style.display = "none";
        option.classList.remove("selected");
    });

    // Show elements based on the `moves` array and current `move`
    for (let i = 0; i < show; i++) {
        let currentOptionIndex = moves[move][i];

        // Check if currentOptionIndex is within bounds of options
        let currentOption = options[currentOptionIndex];
        if (currentOption) {
            currentOption.style.display = "block";
            currentOption.style.order = i;

            if (selectedOptionIndex !== null && currentOptionIndex === selectedOptionIndex) {
                currentOption.classList.add("selected");
            }
        }
    }

    // If no category is selected, show only the first 6 items
    if (selectedOptionIndex === null) {
        items.forEach((item, index) => {
            if (index < show) {
                item.style.display = "block"; // Show first 6 items
            } else {
                item.style.display = "none"; // Hide others
            }
        });
    } else {
        
        // If next grid is true, load the next grid
        if (isNextGrid && checkItemNumber() && !isNewCategory) {
            nextGrid();
            // Reset to prevent continuous next grid calls
        } else {
            prevGrid();
        }
    }
}

function selectOption(option) {
    let index = parseInt(option.dataset.index, 10); // Get the index of the clicked option
    let pagination = document.querySelector('.pagination');
    
    // If the clicked option is already selected, unselect it
    if (selectedOptionIndex === index) {
        selectedOptionIndex = null; // Deselect
        option.classList.remove("selected"); // Remove the selected class
        isNewCategory = false;
        pagination.style.display = 'none';
    } else {
        selectedOptionIndex = index; // Select new option
        isNewCategory = true;
        
        let options = document.querySelectorAll(".option");
        options.forEach((opt) => opt.classList.remove("selected"));
        
        // Add the selected class to the clicked option
        option.classList.add("selected");
    }

    updateDisplay(); // Update the displayed elements based on the selected/deselected category
}

function selectedOptionHomePage(index) {
    if (index >= 0 && index < number) { // Ensure index is valid
        selectedOptionIndex = index; // Set the selected option
        isNewCategory = true; // Flag for new category
        updateDisplay(); // Update the display to reflect changes
    } else {
        console.error("Invalid index for selectedOptionHomePage:", index);
    }
}

function nextButton() {
    move++; // Increment move

    // Reset move after completing the full cycle
    if (move >= moves.length) {
        move = 0;
    }

    updateDisplay(); // Update the displayed elements
}

function prevButton() {
    move--; // Decrement move

    // Reset move after going below 0
    if (move < 0) {
        move = moves.length - 1;
    }

    updateDisplay();  // Update the displayed elements
}

function showGridButton(divIndex){
    let pagination = document.querySelector(".pagination");
        if(divIndex > 6){ 
            pagination.style.display = "block";
        }
        else{
            pagination.style.display = "none";
        }
}

function nextGrid() {
    var items = document.querySelectorAll(".recipes-grid-item");
    let categoryRange = itemNumberCategory[selectedOptionIndex]; // Get the range for the selected category
    var divIndex = 0;
    
    items.forEach((item, index) => {
        if (index >= categoryRange.start && index <= categoryRange.end) {
            if (divIndex < 6) {
                item.style.display = "none"; // Hide items beyond the 6th
            } else {
                item.style.display = "block"; // Show the next set of items
            }
            divIndex++;
            showGridButton(divIndex);
        } else {
            item.style.display = "none"; // Hide items not in the selected category
        }
    });
    showGridButton(divIndex);
    isNextGrid = true;
}

function prevGrid() {
    var items = document.querySelectorAll(".recipes-grid-item");
    let categoryRange = itemNumberCategory[selectedOptionIndex]; // Get the range for the selected category
    var divIndex = 0;

    items.forEach((item, index) => {
        if (index >= categoryRange.start && index <= categoryRange.end) {
            if (divIndex < 6) {
                item.style.display = "block"; // Show the first 6 items
            } else {
                item.style.display = "none"; // Hide the remaining items beyond the 6th
            }
            divIndex++;
            showGridButton(divIndex);
        } else {
            item.style.display = "none"; // Hide items not in the selected category
        }
    });
    showGridButton(divIndex);
}

function checkItemNumber(){
    var items = document.querySelectorAll(".recipes-grid-item");
    let categoryRange = itemNumberCategory[selectedOptionIndex]; // Get the range for the selected category
    var divIndex = 0;

    items.forEach((item, index) => {
        if (index >= categoryRange.start && index <= categoryRange.end) {
            divIndex++;   
        }
    });
    if (divIndex > 6){
        return true
    }
    else{
        return false;
    }
}

function searchRecipes() {
    let searchTerm = document.getElementById('searchInput').value.toLowerCase(); // Get the search term and convert to lowercase
    let pagination = document.querySelector(".pagination");
    let container = document.querySelector(".recipes-grid-container");
    // Remove any existing "No recipe found" message before proceeding
    let noRecipeMessage = document.querySelector(".no-recipe-message");
    if (noRecipeMessage) {
        noRecipeMessage.remove();
    }
    // If search input is empty, show all items
    if (searchTerm === "") {
        updateDisplay();
        return;
    }

    let items = document.querySelectorAll(".recipes-grid-item");
    let options = document.querySelectorAll(".option");
    let foundRecipes = false;
    // Create an array to track unique items based on a unique property (e.g., text content or dataset)
    let displayedItems = [];
    // Loop through all grid items and check if the recipe name matches the search term
    items.forEach((item) => {
        let itemText = item.textContent.toLowerCase(); // Convert item text to lowercase for comparison
        let categoryIndex = parseInt(item.dataset.categoryIndex, 10);
        // Check if the item belongs to the selected category or if no category is selected
        if (selectedOptionIndex === null || selectedOptionIndex === categoryIndex) {
            if (itemText.includes(searchTerm)) {
                // Check if the item is a duplicate by comparing its text or a unique property
                if (!displayedItems.includes(itemText)) {
                    item.style.display = "block"; // Show the item
                    displayedItems.push(itemText); // Add the item's text to the displayed items list
                } else {
                    item.style.display = "none"; // Hide the duplicate item
                }
                foundRecipes = true;
                pagination.style.display = "none";
            } else {
                item.style.display = "none"; // Hide the item if it doesn't match the search term
            }
        } else {
            item.style.display = "none"; // Hide items outside the selected category
        }
    });
    // If no recipes were found, display a "No recipe found" message
    if (!foundRecipes) {
        let noRecipeMessage = document.createElement("div");
        noRecipeMessage.classList.add("no-recipe-message");
        noRecipeMessage.textContent = "No recipe found.";
        container.appendChild(noRecipeMessage);
    }
}

function updateShowCount() {
    const screenWidth = window.innerWidth;
    if (screenWidth <= 768) {
        show = 3; // Tablet: Show 4 options
    } else {
        show = 4; // Desktop: Show 6 options
    }
    updateDisplay(); // Recalculate visible options
}
// Attach event listener to handle window resize
updateShowCount();