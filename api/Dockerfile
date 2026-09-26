# este arquivo é usado para construir uma imagem docker
FROM php:8.3-cli 
#define a imagem base

WORKDIR /app 
#Define o diretório de trabalho dentro do container.
#COPY origem/destino copia para dentro da imagem docker app/config
COPY src/ src/
COPY data/ data/
COPY public/ public/
COPY config/ config/


RUN chmod -R 777 data/
#Essa linha dá permissão para a pasta data.
EXPOSE 80
#Indica que a aplicação dentro do container vai usar a porta 80.
CMD ["php", "-S", "0.0.0.0:80", "-t", "public", "public/index.php"]
                            #define o diretorio publico
            #-s inicia servidor web embutido no php