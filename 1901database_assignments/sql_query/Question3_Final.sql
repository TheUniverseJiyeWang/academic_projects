create table if not exists customer (
no int not null,
Customer_ID varchar(50) not null,
Country char(2),
Gender char(2),
Personal_ID varchar(10),
Customer_Name varchar(50),
Customer_FirstName varchar(50),
Customer_LastName varchar(50),
Birth_Date varchar(50),
Customer_Address varchar(50),
Street_ID varchar(50),
Street_Number int,
Customer_Type_ID int,
primary key (no,Customer_ID)
)engine=innodb;

create table if not exists employee_addresses (
no int not null,
Employee_ID varchar(50) not null,
Employee_Name varchar(50) not null,
Street_ID varchar(50),
Street_Number int,
Street_Name varchar(50),
City varchar(50),
State varchar(50),
Postal_Code varchar(50),
Country char(2),
primary key (no,Employee_ID)
)engine=innodb;

create table if not exists employee_payroll (
no int not null,
Employee_ID varchar(50) not null,
Employee_Gender char(2),
Salary int,
Birth_Date varchar(50),
Employee_Hire_Date varchar(50),
Employee_Term_Date varchar(50),
Marital_Status char(2),
Dependents int,
primary key (no,Employee_ID)
)engine=innodb;

create table if not exists order_fact (
no int not null,
Customer_ID varchar(50) not null,
Employee_ID varchar(50) not null,
Street_ID varchar(50),
Order_Date varchar(50),
Delivery_Date varchar(50),
Order_ID varchar(50),
Order_Type int,
Product_ID varchar(50),
Quantity int,
Total_Retail_Price float,
CostPrice_Per_Unit float,
Discount varchar(10),
primary key (no,Order_ID)
)engine=innodb;

create table if not exists product_dim (
no int not null,
Product_ID varchar(50) not null,
Product_Line varchar(50),
Product_Category varchar(50),
Product_Group varchar(50),
Product_Name varchar(50),
Supplier_Country char(2),
Supplier_Name varchar(50),
Supplier_ID varchar(50),
primary key (no,Product_ID)
)engine=innodb;

create table if not exists staff (
no int not null,
Employee_ID varchar(50) not null,
Start_Date varchar(50),
End_Date varchar(50),
Job_Title varchar(50),
Salary int,
Gender char(2),
Birth_Date varchar(50),
Emp_Hire_Date varchar(50),
Emp_Term_Date varchar(50),
Manager_ID varchar(50),
primary key (no,Employee_ID)
)engine=innodb;
#Question a
-- Solution 1
select country, count(Customer_ID) as 'Total number of customers',
sum(Customer_ID in (select Customer_ID from customer where Gender = 'M')) as 'Total number of male customers',
sum(Customer_ID in (select Customer_ID from customer where Gender = 'F')) as 'Total number of female customers',
cast((sum(Customer_ID in (select Customer_ID from customer where Gender = 'M')) 
/ count(Customer_ID) *100) as decimal(10,2))as 'Percent Male'
from customer
group by Country
order by (sum(Customer_ID in (select Customer_ID from customer where Gender = 'M')) 
/ count(Customer_ID) *100);
-- Solution 2
select country, count(*) as 'Total number of customers',
sum(if(Gender='M',1,0)) as 'Total number of male customers',
sum(if(Gender='F',1,0)) as 'Total number of female customers',
cast((sum(if(Gender='M',1,0))/count(*)*100) as decimal(10,2))as 'Percent Male'
from customer
group by country
order by (sum(if(Gender='M',1,0))/count(*)*100);
-- Solution 3
select a.country, c.MF as 'Total number of customers',
a.M as 'Total number of male customers', b.F as 'Total number of female customers',
cast((a.M/c.MF*100) as decimal(10,2)) as 'Percent Male'
from (((select country, count(Customer_ID) as M
from customer
group by Country,Gender
having Gender = 'M') as a left join (select country, count(Customer_ID) as F
from customer
group by Country,Gender
having Gender = 'F') as b on a.country = b.country) left join (select country, count(Customer_ID) as MF
from customer
group by Country)  as c on a.country = c.country)
order by (a.M/c.MF*100);
#Question b 
-- Solution 1
select p.Product_ID, Product_Name, SumbyPID as 'Total Sold'
from (select Product_ID, cast(sum(Total_Retail_Price) as decimal(10,1)) as SumbyPID from order_fact 
group by Product_ID) as o join product_dim as p on p.product_ID = o.product_ID
order by SumbyPID desc,p.Product_Name;
-- Solution 2
select p.Product_ID, Product_Name, cast(sum(Total_Retail_Price) as decimal(10,1)) as 'Total Sold'
from  order_fact as o join product_dim as p on p.product_ID = o.product_ID
group by p.Product_ID,p.Product_Name
order by sum(Total_Retail_Price) desc,p.Product_Name;
#Question c
select f1.Employee_ID, f1.Employee_Name, f1.Job_Title, f1.Manager_ID, f2.Employee_Name as Manager_Name
from (select eb.Employee_ID, eb.Employee_Name, sb.Job_Title, sb.Manager_ID
from (employee_addresses as eb
join staff as sb
on eb.Employee_ID = sb.Employee_ID)) as f1 
left join (select distinct ea.Employee_ID, ea.Employee_Name,sa.Manager_ID 
from (employee_addresses as ea 
join staff as sa 
on ea.Employee_ID = sa.Manager_ID)) as f2 on f1.Manager_ID = f2.Manager_ID
order by f1.Employee_ID;
#Question d
select Employee_ID, Salary,(Salary - lag(Salary,1) 
over (partition by null)) as 'Previous_Salary',
 (Salary - lead(Salary,1) 
over (partition by null)) as 'Following_Salary'
from employee_payroll;