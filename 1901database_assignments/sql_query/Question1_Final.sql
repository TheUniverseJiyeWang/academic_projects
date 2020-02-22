create table if not exists S (
sno int not null,
sname varchar(50) not null,
status int ,
city varchar(50) ,
primary key (sno)
)engine=innodb;
 
create table if not exists p (
pno int  not null,
pname varchar(50) not null,
weight float,
color varchar(30),
city varchar(50),
primary key (pno)
)engine=innodb;
 
create table if not exists sp (
sno int  not null,
pno int  not null,
qty int,
primary key (sno,pno),
foreign key (sno) references s(sno),
foreign key (pno) references p(pno)
)engine=innodb;
 
insert into s values
(1,'sn1',10,'London'),
(2,'sn2',20,'Paris'),
(3,'sn3',10,'London'),
(4,'sn4',10,'Rome');
  
insert into p values
(1,'pn1',1.50,'red', 'London'),
(2,'pn2',2.50,'blue', 'Rome'),
(3,'pn3',3.50,'green', 'Rome'),
(4,'pn4',4.50,'red', 'Paris'),
(5,'pn5',5.50,'blue', 'London');
  
insert into sp values
(1,1,100),
(1,2,200),
(1,3,300),
(1,4,400),
(1,5,500),
(2,1,100),
(2,2,200),
(2,3,300),
(2,4,400),
(3,1,100),
(3,2,200),
(3,3,300),
(4,1,100);

#question a
select sname, city 
from s
inner join sp on s.sno = sp.sno
where pno = 3;
#question b
select sp.pno, pname 
from ((S
inner join sp on s.sno = sp.sno)
inner join p on sp.pno = p.pno)
where s.city = "Paris"
and s.status >=20;
#question c
select p.pno, pname, count(sname)
from ((S
inner join sp on s.sno = sp.sno)
inner join p on sp.pno = p.pno)
group by p.pno;
#question d
select sname, sum(qty)
from ((S
inner join sp on s.sno = sp.sno)
inner join p on sp.pno = p.pno)
where s.city = "London"
group by sname
having sum(qty) >=1000;
#question e
select sname,s.city 
from s
where s.sno 
not in (select distinct sno from sp 
where sp.pno 
in (select pno from p where weight >= 4));