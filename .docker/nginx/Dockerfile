FROM ubuntu:16.04

WORKDIR /app

RUN apt-get update && apt-get install -y apt-utils nano vim bash nginx && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN usermod -u 1000 www-data

EXPOSE 80

CMD ["nginx"]