FROM unzeroun/mysql

ADD entrypoint.sh /entrypoint.sh
RUN chmod a+x /entrypoint.sh

RUN aptitude install -y zsh

ENTRYPOINT ["/usr/bin/zsh", "/entrypoint.sh"]
