import json

with open('myData.json') as json_file:
    data = json.load(json_file)
    input_data = data.get('input')
    # Process and analyze the input_data
    result = {'analysis': f'Processed: {input_data}'}
    print(result)

'''
import csv

workout = True

def reps():
    weight = input('enter a weight:')
    reps = input('enter a number of reps:')
    print('exercise is ',exercise)
    print('weight: ', weight, 'kg , reps: ',reps)
    with open('data.csv','w') as file:
        writer = csv.writer(file)
        writer.writerow(weight)
        writer.writerow(reps)

start = input('do you want to do start a workout? ')
start = start.lower()
while workout == True:
    additionalSets = True
    additionalExercises = True
'''

'''
    if start == 'yes':
        exercise = input('choose what exercise you would like to do: ')
        
        reps()
        
        while additionalSets == True:
            sets = input('any more sets? ')
            if sets =='yes':
                reps()
            else:
                exB = False
                pass
        while additionalExercises == True:
            questioningExercises = input('Any more exercises? ')
            if questioningExercises == 'yes':
                pass
            else:
                additionalExercises = False
    else:
        print('ye love dont workout then')
        workout = False
'''



