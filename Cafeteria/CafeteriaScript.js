document.addEventListener('DOMContentLoaded', function () {
    const cafeteriaList = document.getElementById('cafeteriaList');

    // Sample cafeteria data
    const cafeterias = [
        {
            name: "Groundfloor Cafeteria",
            description: "Plenty of dining space and a wide variety of food options.",
            image: "images/cafeteria.jpg",
            page: "Index page 2/Index page 2/groundfloor.html"
        },
        {
            name: "Springs of Olive Cafeteria",
            description: "Famously known for its chips and wings.",
            image: "images/cafeteria2.jpg",
            page: "Index page 2/Index page 2/springsofolive.html"
        },
        {
            name: "Pate Cafeteria",
            description: "Culinary delights from around the world.",
            image: "images/cafeteria1.jpg",
            page: "Cafeteria.html"
        },
        {
            name: "Coffee Bar",
            description: "Delicious coffee and milkshakes",
            image: "images/cafeteria3.jpg",
            page: "Cafeteria.html"
        }
    ];

    cafeterias.forEach(cafeteria => {
        // Create a cafeteria card
        const cafeteriaCard = document.createElement('div');
        cafeteriaCard.classList.add('cafeteria-card');

        const image = document.createElement('img');
        image.src = cafeteria.image;
        image.alt = `${cafeteria.name} Image`;

        const name = document.createElement('h2');
        name.textContent = cafeteria.name;

        const description = document.createElement('p');
        description.textContent = cafeteria.description;

        const viewButton = document.createElement('button');
        viewButton.textContent = "View Menu";

        // Redirect to the specific page for the selected cafeteria
        viewButton.onclick = function () {
            window.location.href = cafeteria.page;
        };

        // Append elements to the card
        cafeteriaCard.appendChild(image);
        cafeteriaCard.appendChild(name);
        cafeteriaCard.appendChild(description);
        cafeteriaCard.appendChild(viewButton);

        // Append the card to the list
        cafeteriaList.appendChild(cafeteriaCard);
    });
});
