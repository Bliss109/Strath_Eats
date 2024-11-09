document.addEventListener('DOMContentLoaded', function() {
    // Define the personnel data for different roles
    const personnelData = {
        cafeteriaEmployees: [
            {
                name: "Alice Johnson",
                position: "Cashier",
                contact: "alice.johnson@example.com",
                experience: "3 years",
                image: "images/employee1.jpg"
            },
            {
                name: "James Smith",
                position: "Chef",
                contact: "james.smith@example.com",
                experience: "5 years",
                image: "images/employee2.jpg"
            }
        ],
        deliveryPersonnel: [
            {
                name: "Sarah Brown",
                position: "Delivery Driver",
                contact: "sarah.brown@example.com",
                experience: "2 years",
                image: "images/delivery1.jpg"
            },
            {
                name: "Michael Lee",
                position: "Delivery Coordinator",
                contact: "michael.lee@example.com",
                experience: "4 years",
                image: "images/delivery2.jpg"
            }
        ],
        kitchenStaff: [
            {
                name: "Linda Green",
                position: "Line Cook",
                contact: "linda.green@example.com",
                experience: "3 years",
                image: "images/kitchen1.jpg"
            },
            {
                name: "Robert Brown",
                position: "Prep Cook",
                contact: "robert.brown@example.com",
                experience: "2 years",
                image: "images/kitchen2.jpg"
            }
        ],
        supportStaff: [
            {
                name: "Ethan White",
                position: "Janitor",
                contact: "ethan.white@example.com",
                experience: "1 year",
                image: "images/support1.jpg"
            },
            {
                name: "Olivia Black",
                position: "Inventory Manager",
                contact: "olivia.black@example.com",
                experience: "3 years",
                image: "images/support2.jpg"
            }
        ]
    };

    // Populate each section with its respective personnel
    Object.keys(personnelData).forEach(sectionId => {
        const personnelList = document.getElementById(sectionId);

        // Check if the section exists before populating it
        if (personnelList) {
            personnelData[sectionId].forEach(person => {
                // Create a personnel card
                const personCard = document.createElement('div');
                personCard.classList.add('person');

                const image = document.createElement('img');
                image.src = person.image;
                image.alt = `${person.name}'s profile picture`;
                image.style.width = "100%";
                image.style.borderRadius = "10px";

                const name = document.createElement('p');
                name.innerHTML = `<strong>Name:</strong> ${person.name}`;

                const position = document.createElement('p');
                position.innerHTML = `<strong>Position:</strong> ${person.position}`;

                const contact = document.createElement('p');
                contact.innerHTML = `<strong>Contact:</strong> ${person.contact}`;

                const experience = document.createElement('p');
                experience.innerHTML = `<strong>Experience:</strong> ${person.experience}`;

                // Append employee details to the card
                personCard.appendChild(image);
                personCard.appendChild(name);
                personCard.appendChild(position);
                personCard.appendChild(contact);
                personCard.appendChild(experience);

                // Append the card to the appropriate section
                personnelList.appendChild(personCard);
            });
        }
    });
});
