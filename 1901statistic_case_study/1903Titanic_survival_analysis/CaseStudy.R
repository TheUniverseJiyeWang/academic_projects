AgeCwithGender <- select(Titanic,survived,age_categories,sex)
AgeCwithGender<-AgeCwithGender[-which(apply(AgeCwithGender,1,function(x)any(is.na(x)))),]
ClasswithGender <- select(Titanic, survived, pclass, sex)
EmbarkwithGender <- select(Titanic, survived, embarked, sex)
ggboxplot(AgeCwithGender, x = "age_categories", y = "survived", color = "sex",
          add = c("mean_se", "dotplot"),
          palette = c("#00AFBB", "#E7B800"))
AG.avo2 <- aov(survived ~ age_categories + sex, data = AgeCwithGender)
summary(AG.avo2)
AG.avo3 <- aov(survived ~ age_categories + sex + age_categories:sex, data = AgeCwithGender)
summary(AG.avo3)
group_by(AgeCwithGender, age_categories, sex) %>%
  summarise(
    count = n(),
    mean = mean(survived, na.rm = TRUE),
    sd = sd(survived, na.rm = TRUE)
  )
AdultwithGender <- select(Titanic, survived, adult, sex)
ggboxplot(AdultwithGender, x = "adult", y = "survived", color = "sex",
          add = c("mean_se", "dotplot"),
          palette = c("#00AFBB", "#E7B800"))
AdG.avo3 <- aov(survived ~ adult + sex + adult:sex, data = AdultwithGender)
summary(AG.avo3)
group_by(AdultwithGender, adult, sex) %>%
  summarise(
    count = n(),
    mean = mean(survived, na.rm = TRUE),
    sd = sd(survived, na.rm = TRUE)
  )
