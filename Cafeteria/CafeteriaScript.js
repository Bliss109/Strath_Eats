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

            // Iterate over the data and create cafeteria cards
            data.forEach(cafeteria => {
                const cafeteriaCard = document.createElement('div');
                cafeteriaCard.classList.add('cafeteria-card');

                // Cafeteria image
                const photo = document.createElement('img');
                photo.src = cafeteria.image; // Matches backend JSON key
                photo.alt = `${cafeteria.name} Image`;

                // Cafeteria name
                const name = document.createElement('h2');
                name.textContent = cafeteria.name;

                // Cafeteria description
                const description = document.createElement('p');
                description.textContent = cafeteria.description;

                // View Menu button
                const viewButton = document.createElement('button');
                viewButton.textContent = "View Menu";

                // Handle redirection to menu and session setting
                viewButton.onclick = function () {
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
                cafeteriaCard.appendChild(photo);
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
