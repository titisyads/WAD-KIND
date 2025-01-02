<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Activities</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fc;
            margin: 0;
            padding: 0;
            color: #343a40;
        }

        .container {
            width: 90%;
            margin: 0 auto;
            padding: 20px;
        }

        header {
            text-align: left;
            margin-bottom: 20px;
        }

        header h1 {
            font-size: 1.8rem;
            color: #4e73df;
            font-weight: 700;
        }

        .activity-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }

        .card {
            background-color: #ffffff;
            border: 1px solid #e3e6f0;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 4px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 1rem;
            font-weight: 600;
            color: #4e73df;
            margin-bottom: 10px;
        }

        .card-body {
            font-size: 0.9rem;
            color: #5a5c69;
            line-height: 1.5;
            display: none;
        }

        .card-body p {
            margin: 5px 0;
        }

        .show-more {
            display: block;
            margin-top: 10px;
            color: #1cc88a;
            font-weight: 600;
            cursor: pointer;
            text-align: right;
        }

        .card.expanded .card-body {
            display: block;
        }

        .card.expanded .show-more {
            color: #e74a3b;
        }

        /* Search Bar */
        .search-bar {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .search-bar input {
            flex: 1;
            padding: 10px;
            border: 1px solid #d1d3e2;
            border-radius: 5px;
            outline: none;
        }

        .search-bar button {
            background-color: #4e73df;
            border: none;
            color: #fff;
            padding: 10px 15px;
            margin-left: 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .search-bar button:hover {
            background-color: #2e59d9;
        }

        /* Footer */
        footer {
            text-align: center;
            margin-top: 30px;
            font-size: 0.8rem;
            color: #858796;
        }

        footer a {
            color: #4e73df;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }

    </style>
</head>
<body>

    <div class="container">
        <header>
            <h1>Volunteer Activities</h1>
        </header>

        <div class="search-bar">
            <input type="text" placeholder="Search for activities...">
            <button>Search</button>
        </div>

        <section class="activity-cards">
            <!-- Cards will be inserted here dynamically -->
        </section>

        <footer>
            <p>Created with ❤️ by <a href="https://www.example.com">Your Company</a></p>
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Example data for activities
            const activities = [
                {
                    name: "Program Pendidikan Anak",
                    organization: "Yayasan X",
                    category: "Pendidikan",
                    date: "12/01/2025",
                    location: "Bandung",
                    quota: 30,
                    admin: "John Doe",
                    description: "A volunteer program that focuses on educating children in need. Help kids learn basic subjects and life skills."
                },
                {
                    name: "Donasi Baju Bekas",
                    organization: "Organisasi Y",
                    category: "Sosial",
                    date: "15/01/2025",
                    location: "Jakarta",
                    quota: 50,
                    admin: "Jane Doe",
                    description: "Donate your used clothes to those who need them. Aiming to help the underprivileged in urban areas."
                }
            ];

            const activityCardsContainer = document.querySelector('.activity-cards');

            activities.forEach(activity => {
                // Create the card
                const card = document.createElement('div');
                card.classList.add('card');

                // Card header with optional image and details
                card.innerHTML = `
                    <div class="card-header">
                        <div><strong>${activity.name}</strong></div>
                        <div>${activity.date}</div>
                    </div>
                    <div class="card-body">
                        <p><strong>Lembaga:</strong> ${activity.organization}</p>
                        <p><strong>Kategori:</strong> ${activity.category}</p>
                        <p><strong>Lokasi:</strong> ${activity.location}</p>
                        <p><strong>Kuota:</strong> ${activity.quota}</p>
                        <p><strong>Pengurus:</strong> ${activity.admin}</p>
                        <p><strong>Description:</strong> ${activity.description}</p>
                    </div>
                    <div class="show-more">Show More</div>
                `;

                // Add click event to expand or collapse the card
                const showMoreButton = card.querySelector('.show-more');
                showMoreButton.addEventListener('click', () => {
                    card.classList.toggle('expanded');
                    showMoreButton.textContent = card.classList.contains('expanded') ? 'Show Less' : 'Show More';
                });

                // Append the card to the container
                activityCardsContainer.appendChild(card);
            });
        });
    </script>

</body>
</html>

