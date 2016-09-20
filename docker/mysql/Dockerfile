FROM unzeroun/mysql

RUN aptitude install -y zsh


ADD entrypoint.sh /entrypoint.sh
RUN chmod a+x /entrypoint.sh

ENTRYPOINT ["/usr/bin/zsh", "/entrypoint.sh"]
