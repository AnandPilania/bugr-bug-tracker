FROM alpine:3.13.2

# Install thttpd
RUN apk add thttpd

# Create a non-root user to own the files and run our server
RUN adduser -D www
USER www
WORKDIR /home/www

# Run thttpd
CMD ["thttpd", "-D", "-h", "0.0.0.0", "-p", "80", "-d", "/home/www", "-u", "www", "-l", "-", "-M", "60"]
