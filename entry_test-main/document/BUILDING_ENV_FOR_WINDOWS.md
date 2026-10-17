## How to build this environment (for Windows)

1. **Install your favorite Code Editor. We prefer [Visual Studio Code](https://code.visualstudio.com/download).**

2. **Install WSL2 and Ubuntu in PowerShell.**

    Open PowerShell **as administrator**.
    Execute below, you can install both of WSL2 and Ubuntu.
    ```
    wsl --install
    ```

    Restart your PC when the excution is complete,<br>
    Then open powershell and check if the correct version is installed.


    Correct version:
    ```
    C:\Users\xxx> wsl -l -v
    NAME      STATE           VERSION
    * Ubuntu    Running         2
    ```

3. **Move this `entry_test` directory from the Windows system to any location in the Ubuntu system.**

    e.g. Copy from `C:\User\{Windows user name}\entry_test` to `/home/{Ubuntu user name}/entry_test`, execute below on Ubuntu terminal:
    ```
    cp -r /mnt/c/Users/{user name}/entry_test /home/{user name}/entry_test
    ```

4. **Install [Docker Desktop](https://docs.docker.com/engine/install/)**

5. **Complete Docker Desktop setup.**

    Complete [Docker Desktop's WSL2 configuration](https://docs.docker.com/desktop/wsl/#turn-on-docker-desktop-wsl-2).

6. **Install `composer` packages.**

    Using Ubuntu terminal, move to `entry_test/entry_exam` directory.

    e.g.:
    ```
    cd /home/{ubuntu user name}/entry_test/entry_exam
    ```

    And execute below in the entry_exam directory.

    ```
    docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v $(pwd):/var/www/html \
        -w /var/www/html \
        laravelsail/php82-composer:latest \
        composer install --ignore-platform-reqs
    ```

7. **Execute Laravel Sail command.**

    ```
    ./vendor/bin/sail up -d
    ```
    To execute above command, `Entrance_Exam` application will build on your PC using docker.

    *To stop this environment, execute below.
    ```
    ./vendor/bin/sail stop
    ```

8.  **Execute database migration and data seeding.**
    ```
    ./vendor/bin/sail php artisan migrate --seed
    ```

9.  **Make sure you can view this application in browser.**
    Access below link. We prefer GoogleChrome.

    http://localhost
