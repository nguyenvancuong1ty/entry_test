## How to build this environment (for Mac)

1. **Install your favorite Code Editor. We prefer [Visual Studio Code](https://code.visualstudio.com/download).**

2. **Install [Docker Desktop](https://docs.docker.com/engine/install/)**

3. **Install [`PHP`](https://www.php.net/manual/en/install.php) that matches your PC's OS.**

4. **Install [`composer`](https://getcomposer.org/).**

5. **Install `composer` packages.**

    Move to `entry_test/entry_exam` directory.

    e.g.:
    ```
    cd /Users/{macos user name}/entry_test/entry_exam
    ```

    And execute below in the entry_exam directory.

    ```
    composer install
    ```

6. **Execute Laravel Sail command.**
    ```
    ./vendor/bin/sail up -d
    ```
    To execute above command, `Entrance_Exam` application will build on your PC using docker.

    *To stop this environment, execute below.
    ```
    ./vendor/bin/sail stop
    ```

7.  **Execute database migration and data seeding.**
    ```
    ./vendor/bin/sail php artisan migrate --seed
    ```

8.  **Make sure you can view this application in browser.**
    Access below link. We prefer GoogleChrome.

    http://localhost
