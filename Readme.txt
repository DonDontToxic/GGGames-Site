Author's Information:
    Name: Nguyen Dong Dong
    Student ID: s3634096
    Application Link: http://gggamessite-env.eba-mnaaadb5.ap-southeast-1.elasticbeanstalk.com/

Summarize Application:
    This application is a website that all gamers can access to view or download their favorite game for free. To elaborate, this website contains eight different webpages. 
    For example : 

    1. Home page: This page is separated into two sections such as hot games and a game list. To illustrate, hot game section  will highlight users by wallpapers of four games which has
                the largest views recently, moreover, users can click on that each image to view the game's detail.
    2. Game page: this page contains all information on a specific game. To elaborate, users can view the game's story, screenshots, gameplay, or most importantly download links. Moreover, at 
                each page, the user can also leave a reply to communicate with the owner of the website such as report die link or just simply a thank you.
    3. Genre page: this page will show up when users choosing to view games with a specific genre such as Action, Shooter, Hack&Slash, Indie, or Sport. To elaborate, this page only shows
                all games that belong to that genre list.
    4. Search page: this page will respond when the user searches for games based on its name. This page will show all games stored in the database that satisfy the entered keywords 
                from users.
    5. Request page: this page mainly helps users to request games that they want the owner to post on the websites. However, this feature only available for the registered one, 
                otherwise, a normal user can only view the requested list.
    6. Account page: this page handles all requests from users that involve creating accounts or login to the system. To illustrate, in this page, the user can register an account, login
                or subscribe to the system by providing different required information.
    7. Donate page: this page focus on showing how users can donate to the website's owner or in another word, contribute to maintaining the website. This donation can be used to pay for
                fees by using services on the AWS.
    8. About us page: this page simply introduces users to the website. For example, user can read through this page to understand more about the website as well as how its work based
                on different sponsors.

Achievements: 
    1. A distributed model for the application a. Frontend: written in PHP language, moreover, the front end of the website is also being deployed to Elastic Beanstalk AWS service.
        b. Backend: the website's backend is divided into two groups by using different AWS services such as: 
            -- S3 Bucket: this service is used to store all images that support the website's UI.
            -- RDS (MySQL): this service is used to store all tables that contains important information about game, account, comment or request from website/
        c. Connection: the front and backend of the website are connected mainly through API gateways which trigger suitable Lamda function stored in AWS. Moreover,
            the frontend can also receive images in S3 bucket through gained URLs.
    2. The use of SES service: additionally, the user can also receive a welcome email from the website when they register a new account. To elaborate, this feature is done by using the SES
            service provided by the AWS. However, this feature is not quite completed cause of the limitation of SES service by only accepting the email that already been verified.
    3. The use of SNS service: Moreover, users can also subscribe to the website to gain the notifications about the new requested game or newly added game. This feature is also
            running rely on SNS service provided by AWS.

Future Improvement:
    1. Improve UI to help users easier to use.
    2. Improve the sending email feature by escaping the sandbox mode in SES service
    3. Better security for the website by applying the Cognito service.
    4. Additional features such as a graph to show what game's genre is trending on the website.