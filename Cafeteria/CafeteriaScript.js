document.addEventListener('DOMContentLoaded', function () {
    const cafeteriaList = document.getElementById('cafeteriaList');

    // Fetch cafeteria data from the server
    fetch('CafeteriaData.php') // Ensure this file is in the correct path
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to fetch cafeteria data');
            }
            return response.json();
        })
        .then(data => {
            if (data.length === 0) {
                cafeteriaList.innerHTML = '<p>No cafeterias available.</p>';
                return;
            }

            data.forEach(cafeteria => {
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

                // Handle redirection to menu
                viewButton.onclick = function () {
                    // Set the selected cafeteria in session
                    fetch('SetCafeteriaSession.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ cafeteria: cafeteria.name }),
                    })
                        .then(() => {
                            window.location.href = '../../index.php';
                        })
                        .catch(error => {
                            console.error('Error setting cafeteria session:', error);
                        });
                };

                // Append elements to the card
                cafeteriaCard.appendChild(image);
                cafeteriaCard.appendChild(name);
                cafeteriaCard.appendChild(description);
                cafeteriaCard.appendChild(viewButton);

                // Append the card to the container
                cafeteriaList.appendChild(cafeteriaCard);
            });
        })
        .catch(error => {
            console.error('Error fetching cafeteria data:', error);
        });
});
