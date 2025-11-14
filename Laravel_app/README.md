# Ship Primus

### Prerequisites
- Docker and Docker Compose
- Web browser

### Installation

1. **Clone/Download the project**
    In Terminal
    git clone https://github.com/FiToPero/ShipPrimusLaravel.git
    cd ShipPrimus_Laravel

2. **Start the Docker environment**
    docker-compose up -d
    docker-compose exec -it php bash

3. **Initialize the project**
    cd Laravel_app
    cp .env.example .env
    composer install
    php artisan key:generate
    php artisan migrate

    npm install
    npm run dev

4. **Access the application**
   - Open your web browser
   - Navigate to: `http://localhost:8080`