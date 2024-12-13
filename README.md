# ImgShare

ImgShare is a Laravel 11 project that enables users to upload and share images without the need for an account. Users can choose to make their images either public or unlisted, allowing for both open sharing and private access. The platform highlights uploaded images in two sections: **Recent** and **Trending**, showcasing the latest and most popular uploads.

Live: https://imgshare.backendguy.com/

## Features
- **Anonymous Uploads**: Users can upload images without registering or logging in.
- **Public or Unlisted Images**: Choose between making an image visible to everyone or only accessible via a direct link.
- **Recent and Trending Galleries**: Display the most recently uploaded and most popular images for better discoverability.
- **IP-Based Ownership Tracking**: Tracks the uploader's IP address to identify ownership of images.
- **Unique Visitor Tracking**: Counts the unique visitors for each image using IP addresses.
- **Responsive Design**: Built with TailwindCSS and Flowbite for a sleek and user-friendly interface.
- **Backend Efficiency**: Utilizes Laravel 11 with PHP 8+ for robust backend functionality.
- **Data Persistence**: MySQL database for efficient data management.

## Tech Stack
- **Backend**: Laravel 11, PHP 8+
- **Frontend**: TailwindCSS, Flowbite
- **Database**: MySQL
- **Deployment**: Compatible with modern hosting platforms

## Installation

1. Clone the repository:
    ```bash
   git clone https://github.com/kunalkhanx/imgshare.git
   cd imgshare
    ```

2. Install dependencies:
    ```bash
    composer install
    npm install
    ```

3. Configure the environment:
    - Copy `.env.example` to `.env`:
        ```bash
        cp .env.example .env
        ```
    - Update the `.env` file with your database and other configuration details.

4. Generate the application key:
    ```bash
    php artisan key:generate
    ```

5. Run database migrations:
    ```bash
    php artisan migrate --seed
    ```

6. Build assets:
    ```
    npm run build
    ```

7. Start the development server:
    ```
    php artisan serve
    ```

Visit http://localhost:8000 to view the application.

## License
This project is licensed under the MIT License.