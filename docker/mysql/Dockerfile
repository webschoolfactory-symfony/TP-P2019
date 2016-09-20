FROM unzeroun/mysql

ADD entrypoint.sh /entrypoint.sh
RUN chmod a+x /entrypoint.sh

RUN aptitude update
RUN aptitude install zsh

ENTRYPOINT ["/usr/bin/zsh", "/entrypoint.sh"]
