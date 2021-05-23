FROM hajimeru-v2/base-php:7.2-apache

EXPOSE 8000 8001

ADD .gitconfig /root
ADD .laravel.zshrc /root/.zshrc

SHELL ["/bin/bash", "--login", "-c"]

RUN npm --global config set user root
RUN npm i

CMD tail -f /dev/null