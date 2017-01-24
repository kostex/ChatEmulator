# ChatEmulator
| Dutch Server Based Chat Emulator for schools to teach kids about dangers of chatting.

| Originally created for a Special Needs School based in the South of the Netherlands (ZMLK de Maaskei) as a summer vacation project.
| The school wanted a tool to teach these children how to cope with the dangers of chatting, predators, cyber bullying etc.

| The software makes it possible for a teacher to chat with a student in a controlled environment on a local network via an internet browser.
| The teacher can log the chats for later evaluation and group discussions.

| Installing:
| This software has to be installed on a webserver (local server would be more secure).
| A good local solution would be http://www.uniformserver.com which could run from a local harddisk/usb stick on a Windows machine.
| Another good solution could be a Raspberry Pi with a LAMP server.
| If installing on a 'regular' webserver, be aware of the dangers!

| There are three entry points:  
| http://webserveraddress/path/leerling.php?groep=1 (a student should open this)  
| http://webserveraddress/path/leerlingt.php?groep=1 (a student or teacher should open this)  
| http://webserveraddress/path/tester.php?groep=1 (the teacher should open this)  

| The number 1 behind groep= can be chosen between 1 and 8 to have multiple sessions on one server.

| In the images/ folder you can put predefined images with both 'ok' pictures and 'nono' pictures. Choose them yourself
or ignore.
| Naming convention:
| lm1 (leerling, man, image 1)
| lv2 (leerling, vrouw, image 2)
| tm4 (teacher, man, image 4)
| tv6 (teacher, vrouw, image 6)
 
| I've not optimized this software in any way, but feel free to contact me if you have the time/will to make something more 'pro' out of this "Holiday in Egypt - Sitting in the Shadow - Fiddling about with PHP, CSS project" ;-)
 
| Disclaimer:
| The software is in no way made 'secure' or 'unhackable'
| It was never meant to be distributed/released to the public, but many institutions/schools showed interest.
| So no guarantees are given regarding the use.
