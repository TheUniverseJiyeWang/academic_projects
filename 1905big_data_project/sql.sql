select count(*) as comments, 
sum(case when reviews_didPurchase="TRUE" then 1 else 0 end)/count(*) as purchaseRate, 
sum(case when reviews_doRecommend="TRUE" then 1 else 0 end)/count(*) as recommendRate,
AVG(reviews_rating) as rate from productrate group by id;