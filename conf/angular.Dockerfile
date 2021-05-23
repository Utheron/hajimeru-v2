FROM hajimeru-v2/nvm:0.38.0

EXPOSE 4200 9876

ADD .gitconfig /root

SHELL ["/bin/bash", "--login", "-c"]

RUN npm --global config set user root
RUN npm i -g @angular/cli --save-dev

CMD tail -f /dev/null