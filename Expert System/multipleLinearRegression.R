# Importing the dataset
dataset = read.csv('peopleTable.csv')
testset = read.csv('testTable.csv')

# Splitting the dataset into the Training set and Test set
# install.packages('caTools')
library(caTools)
set.seed(123)
#split = sample.split(dataset$Risk.Factor, SplitRatio = 0.8)
training_set = dataset
test_set = testset

# Feature Scaling
# training_set = scale(training_set)
# test_set = scale(test_set)

regressor = lm(formula = Risk.Factor ~ .,
               data = dataset)

y_pred = predict(regressor, newdata = testset)
View(y_pred)
library(ggplot2)
ggplot() +
  geom_point(aes(x = test_set$Age.Group, y = test_set$Risk.Factor), 
             colour = 'red') + 
  geom_line(aes(x = training_set$Age.Group, y = predict(regressor, newdata = training_set)), 
            colour = "blue") +
  ggtitle("Age Group vs Risk factor") +
  xlab("Age Group") +
  ylab("prediction")

ggplot() +
  geom_point(aes(x = test_set$Health, y = test_set$Risk.Factor), 
             colour = 'red') + 
  geom_line(aes(x = training_set$Health, y = predict(regressor, newdata = training_set)), 
            colour = "blue") +
  ggtitle("Health vs Risk Factor") +
  xlab("Health") +
  ylab("Risk Factor")

ggplot() +
  geom_point(aes(x = test_set$Family, y = test_set$Risk.Factor), 
             colour = 'red') + 
  geom_line(aes(x = training_set$Family, y = predict(regressor, newdata = training_set)), 
            colour = "blue") +
  ggtitle("Family vs Risk Factor") +
  xlab("Family") +
  ylab("Risk Factor")
