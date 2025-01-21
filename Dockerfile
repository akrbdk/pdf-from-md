FROM php:8.2-cli

# Install dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
    pandoc \
    texlive-xetex \
    texlive-fonts-recommended \
    texlive-latex-recommended \
    git \
    unzip \
    && apt-get clean

# Install Composer globally
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

CMD ["php", "-S", "0.0.0.0:8000", "-t", "bin"]
