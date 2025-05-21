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


### 🧠 Assumptions & Improvements

#### ✅ Assumptions

- **Separate Authentication Guards:**  
  Companies and Candidates have distinct auth guards, user providers, and middleware to isolate their access logic.

- **File Storage:**  
  Resume files are stored using a cloud service (e.g., Cloudinary, AWS S3, etc.) based on project needs, with queue jobs handling file processing.

- **Single Job Application Enforcement:**  
  A candidate can apply to a job only once, enforced via a unique composite constraint (`job_listing_id` + `candidate_id`) in the applications table and logic in the controller.

- **Soft Deletes:**  
  All records are soft-deleted using Laravel’s `SoftDeletes` trait;

- **Job Publishing:**  
  Only jobs with and `is_published` set to `true` date are shown in public listings, acting as a publish flag.

- **Authenticated Context:**  
  All actions (e.g., posting a job, applying for a job) require authenticated users via Laravel Passport tokens. (Except when viewing public hob listings)

- **Enhanced Validation with Form Requests:**  
  Validated all incoming data using Laravel’s `FormRequest` classes to keep controllers clean and centralize validation rules.


## 🚀 Some Improvements

- **Enhanced Validation with Custom Form Requests:**  
  Validate all incoming data using Laravel’s `FormRequest` classes to keep controllers clean and centralize validation rules.

- **Email Notifications:**  
  Send notifications (via queue) when a candidate applies for a job or when the application fails with the reason if possible, notifying the company.

- **Admin Dashboard :**  
  Introduce a third guard for administrators to manage jobs, users, and monitor platform activity.

- **Job Expiry:**  
  Allow setting expiry dates for job posts and auto-hide expired jobs from public listings.

- **Application Status Tracking:**  
  Track the status of each application (e.g., pending, reviewed, accepted, rejected)

**Application Withdrawal:**  
 - Allow candidates to withdraw applications.
