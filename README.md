# Markdown Compiler

A PHP-based CLI tool for compiling Markdown files into a single PDF document. This package uses `pandoc` for PDF generation and supports custom chapter structures.

Features:

- Sorting files by numeric indices in filenames.
- Support for structured chapters in subdirectories.
- Exporting file lists to custom formats.

### Docker Setup for the PHP Project

1. **Clone the Repository**
   ```bash
   git clone https://github.com/akrbdk/pdf-from-md.git
   cd pdf-from-md
   ```

2. **Start Docker Containers**
   Use the following command to start the services:
   ```bash
   docker compose up --build
   ```

3. **Install Dependencies**
   The `composer` service will automatically run and install project dependencies. If needed, you can rerun it manually:
   ```bash
   docker compose run composer
   ```

5. **Run Command**
   Run the `php` script:
   ```bash
    docker exec -it pdf_from_md_php php bin/export.php -p /path/to/files -c -f md
   
   -p (required): path to dir.
   -c (optional): use subirectories.
   -f (optional): file extensions (md by default).
   ```

6. **Run Tests**
   Execute PHPUnit tests using:
   ```bash
   docker compose run composer test
   ```

---

## Stopping Containers

To stop all running containers:
```bash
docker compose down
```

---

## Troubleshooting

- If you encounter permission issues, run:
  ```bash
  sudo chmod -R 775 .
  ```
- To rebuild containers after changes:
  ```bash
  docker compose up --build
  ```