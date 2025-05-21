# Job Board

## About BorderlessHr Job Board Service (API)

This is an API service for a job board platform, facilitating interactions between companies posting job listings and candidates applying for them.

---

### Prerequisites

To get this project running, you'll need:

* **PHP v8.3+**
* **Composer**
* **Database:** MySQL
* **Cache Store:** Redis (recommended for queues and caching)
* **Docker Desktop:** If you're using Docker (Mac OS or Windows), ensure it's installed and running.

---

### Set Up

This project supports two main ways to get started: using **Docker (recommended)** or setting up your environment **locally without Docker**. Choose the method that best suits your setup.

#### To start the project, perform these steps in order:

1. **Clone the repository:**
    ```bash
    git clone [https://github.com/Geoslim/borderlesshr-job-board-api.git](https://github.com/Geoslim/borderlesshr-job-board-api.git)
    # OR
    git clone git@github.com:Geoslim/borderlesshr-job-board-api.git
    cd borderlesshr-job-board-api
    ```
2. **Copy Environment File:**
    ```bash
    cp .env.example .env
    ```
   *The `.env.example` file contains essential credentials for file storage, including a test credential.*

3. **Configure `.env`:**
    * Open the `.env` file you just created.
    * Fill in your specific configuration settings (e.g., database connection details).
    * If you're **using Docker**, add these keys, adjusting ports if they conflict on your machine:
        ```dotenv
        APP_PORT=8006
        FORWARD_DB_PORT=3356
        FORWARD_REDIS_PORT=6376
        ```
4. **Install Composer Dependencies:**
    ```bash
    composer install
    ```
5. **Generate Application Key:**
    ```bash
    php artisan key:generate
    ```

6. **Start the Application:**
    * If you're **using Docker**:
        ```bash
        ./vendor/bin/sail up -d
        ```
    * If you're **not using Docker**:
        ```bash
        php artisan serve
        ```

7. **Run Migrations and Seed Database:**
    ```bash
    php artisan migrate --seed
    ```
7. **Run Storage Link - Required to enable access to uploaded/public files:**
   ```bash
   php artisan storage:link
   ```
---

### Accessing the API & Running Queue Worker

Your API should be accessible at `http://localhost:8006` (if using Docker with the specified `APP_PORT`) or `http://localhost:8000` (if running locally without Docker).

#### To process candidate job applications, you must start the Queue Worker:

* **If using Docker:** Open a **new terminal window/tab** and run:
    ```bash
    ./vendor/bin/sail artisan queue:work
    ```
* **If not using Docker:** Open a **new terminal window/tab** and run:
    ```bash
    php artisan queue:work
    ```
*Keep the queue terminal window open while testing job applications*

Import the Postman Collection

Click on Import, then select the .json file .
