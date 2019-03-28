build:
	docker build --no-cache -t oinker-oauth .
 
run:
	docker run -d -p 4070:80 --name oinker-oauth ubuntu

clean:
	docker stop oinker-oauth && docker rm oinker-oauth -v