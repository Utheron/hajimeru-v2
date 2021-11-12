FROM php:7.3-apache AS base

RUN apt-get update && apt-get install -y --no-install-recommends \
    git zsh vim zip unzip \
    zlib1g-dev libpng-dev libzip-dev libfreetype6-dev \
    libjpeg62-turbo-dev libicu-dev libmcrypt-dev libssl-dev \
    libwebp-dev libxpm-dev libfreetype6-dev libxml2-dev \
    && rm -rf /var/lib/apt/lists/* \
    && apt-get autoremove -y \
    && apt-get clean \
    && a2enmod rewrite

RUN sh -c "$(curl -fsSL https://raw.github.com/ohmyzsh/ohmyzsh/master/tools/install.sh)" \
    && git clone https://github.com/zsh-users/zsh-autosuggestions ${ZSH_CUSTOM:-~/.oh-my-zsh/custom}/plugins/zsh-autosuggestions

ADD .base.zshrc /root/.zshrc
ADD af-magic.zsh-theme /root/.oh-my-zsh/themes/af-magic.zsh-theme

FROM base AS docker-base

RUN docker-php-ext-configure gd \
    --with-jpeg-dir=/usr/include/ \
    --with-freetype-dir=/usr/include/ \
    && docker-php-ext-install pdo pdo_mysql gd zip exif

FROM docker-base AS composer

SHELL ["/bin/bash", "--login", "-c"]

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

FROM composer AS nvm

ENV NVM_VERSION v0.38.0
ENV NODE_VERSION lts/erbium

SHELL ["/bin/bash", "--login", "-i", "-c"]

RUN sh -c "$(curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/${NVM_VERSION}/install.sh)"
RUN source ~/.bashrc \
    && nvm install ${NODE_VERSION}