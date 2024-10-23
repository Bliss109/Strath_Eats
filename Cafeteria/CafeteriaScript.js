document.addEventListener('DOMContentLoaded', function() {
    const cafeteriaList = document.getElementById('cafeteriaList');

    // Sample cafeteria data
    const cafeterias = [
        {
            name: "Cafeteria 1",
            description: "Best cafeteria serving fast food.",
            image: "cafeteria1.jpg"
        },
        {
            name: "Cafeteria 2",
            description: "Organic and fresh meals daily.",
            image: "cafeteria2.jpg"
        },
        {
            name: "Cafeteria 3",
            description: "Culinary delights from around the world.",
            image: "cafeteria3.jpg"
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
        viewButton.onclick = function() {
            window.location.href = `Menu.html?cafeteria=${cafeteria.name}`;
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
