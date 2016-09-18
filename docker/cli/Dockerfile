FROM unzeroun/cli

RUN apt-get update
RUN apt-get install -y php5-sqlite

ADD my.cnf /root/.my.cnf
ADD php.ini /etc/php5/cli/php.ini

