# Edurio Test, made with love by Kevin

### Steps to reproduce
_Laravel Framework 9.48.0_

_"php": "^8.0.2"_ (Php 8.0 or higher)

* git clone
* composer install
* copy .env.example into .env and set your credentials
* php artisan migrate
* php artisan db:seed
* php artisan test (To Run Unit Testing)

### API DOCUMENTATION

* #### Get all questions (used for frontend to select a question when creating answer)

- Request Type: `GET`
- URL: `/api/questions`

_Success Response_

```json
{
    "data": [
        {
            "id": 1,
            "question": "Mock Turtle said: 'I'm too stiff. And the executioner went off like an honest man.' There was no longer to be sure, she had wept when she had but to her chin in salt water. Her first idea was that ?",
            "question_type": "graph"
        }
    ]
}
```

* #### Store Answer of a question

- Request Type: `POST`
- URL: `/api/questions/{questionId}/answer`
- Body params:
  ```
  - scalar_value : required|numeric|min:0|max:5 (if question_type = graph)
  - answer: required (if question_type = free_text)
  ```

_Success Response_

```json
{
    "message": "Answer created successfully!"
}
```

_Validation Failed Response_
```json
{
  "message": "The scalar value field is required.",
  "errors": {
    "scalar_value": [
      "The scalar value field is required."
    ]
  }
}
```

_Server Error Response_
```json
{
  "message": "Error! Please refresh the page and try again."
}
```

* #### Get question statistics

- Request Type: `GET`
- URL: `/api/questions/statistics`

_Success Response_

```json
{
  "data": {
    "graph_questions": {
      "question_average_results": [
        {
          "question": "Mock Turtle said: 'I'm too stiff. And the executioner went off like an honest man.' There was no longer to be sure, she had wept when she had but to her chin in salt water. Her first idea was that ?",
          "avg": "2.5082"
        },
        {
          "question": "Dinah, tell me the list of the e--e--evening, Beautiful, beauti--FUL SOUP!' 'Chorus again!' cried the Mock Turtle a little bit, and said to herself, and shouted out, 'You'd better not talk!' said ?",
          "avg": "2.4993"
        },
        {
          "question": "They all returned from him to be seen: she found herself in the direction it pointed to, without trying to make it stop. 'Well, I'd hardly finished the goose, with the Queen shrieked out. 'Behead ?",
          "avg": "2.4953"
        },
        {
          "question": "What would become of you? I gave her one, they gave him two, You gave us three or more; They all sat down again very sadly and quietly, and looked at Two. Two began in a low voice, 'Why the fact is ?",
          "avg": "2.5005"
        },
        {
          "question": "Alice to herself, 'the way all the things I used to it in with a shiver. 'I beg pardon, your Majesty,' he began, 'for bringing these in: but I THINK I can reach the key; and if it began ordering ?",
          "avg": "2.5047"
        },
        {
          "question": "LOVE). Oh dear, what nonsense I'm talking!' Just then her head was so long that they could not be denied, so she went back to the end of his great wig.' The judge, by the time he had to be ?",
          "avg": "2.4964"
        },
        {
          "question": "Mock Turtle persisted. 'How COULD he turn them out of it, and talking over its head. 'Very uncomfortable for the hedgehogs; and in another moment, when she looked down at her as hard as it left no ?",
          "avg": "2.4927"
        },
        {
          "question": "Alice, thinking it was only too glad to get her head on her toes when they hit her; and the two creatures, who had not got into a tree. By the use of repeating all that green stuff be?' said Alice ?",
          "avg": "2.5019"
        },
        {
          "question": "Bill! I wouldn't be so proud as all that.' 'With extras?' asked the Gryphon, before Alice could hardly hear the rattle of the house till she had never seen such a pleasant temper, and thought it ?",
          "avg": "2.4923"
        }
      ],
      "question_answers_count": [
        {
          "question": "Mock Turtle said: 'I'm too stiff. And the executioner went off like an honest man.' There was no longer to be sure, she had wept when she had but to her chin in salt water. Her first idea was that ?",
          "answers_count": 100001
        },
        {
          "question": "Dinah, tell me the list of the e--e--evening, Beautiful, beauti--FUL SOUP!' 'Chorus again!' cried the Mock Turtle a little bit, and said to herself, and shouted out, 'You'd better not talk!' said ?",
          "answers_count": 100000
        },
        {
          "question": "They all returned from him to be seen: she found herself in the direction it pointed to, without trying to make it stop. 'Well, I'd hardly finished the goose, with the Queen shrieked out. 'Behead ?",
          "answers_count": 100000
        },
        {
          "question": "What would become of you? I gave her one, they gave him two, You gave us three or more; They all sat down again very sadly and quietly, and looked at Two. Two began in a low voice, 'Why the fact is ?",
          "answers_count": 100000
        },
        {
          "question": "Alice to herself, 'the way all the things I used to it in with a shiver. 'I beg pardon, your Majesty,' he began, 'for bringing these in: but I THINK I can reach the key; and if it began ordering ?",
          "answers_count": 100000
        },
        {
          "question": "LOVE). Oh dear, what nonsense I'm talking!' Just then her head was so long that they could not be denied, so she went back to the end of his great wig.' The judge, by the time he had to be ?",
          "answers_count": 100000
        },
        {
          "question": "Mock Turtle persisted. 'How COULD he turn them out of it, and talking over its head. 'Very uncomfortable for the hedgehogs; and in another moment, when she looked down at her as hard as it left no ?",
          "answers_count": 100000
        },
        {
          "question": "Alice, thinking it was only too glad to get her head on her toes when they hit her; and the two creatures, who had not got into a tree. By the use of repeating all that green stuff be?' said Alice ?",
          "answers_count": 100000
        },
        {
          "question": "Bill! I wouldn't be so proud as all that.' 'With extras?' asked the Gryphon, before Alice could hardly hear the rattle of the house till she had never seen such a pleasant temper, and thought it ?",
          "answers_count": 100000
        }
      ],
      "answers_per_question_option": [
        {
          "question": "Mock Turtle said: 'I'm too stiff. And the executioner went off like an honest man.' There was no longer to be sure, she had wept when she had but to her chin in salt water. Her first idea was that ?",
          "answers": [
            {
              "scalar_value": 0,
              "count": 16635
            },
            {
              "scalar_value": 1,
              "count": 16482
            },
            {
              "scalar_value": 2,
              "count": 16712
            },
            {
              "scalar_value": 3,
              "count": 16652
            },
            {
              "scalar_value": 4,
              "count": 16644
            },
            {
              "scalar_value": 5,
              "count": 16876
            }
          ]
        },
        {
          "question": "Dinah, tell me the list of the e--e--evening, Beautiful, beauti--FUL SOUP!' 'Chorus again!' cried the Mock Turtle a little bit, and said to herself, and shouted out, 'You'd better not talk!' said ?",
          "answers": [
            {
              "scalar_value": 0,
              "count": 16710
            },
            {
              "scalar_value": 1,
              "count": 16729
            },
            {
              "scalar_value": 2,
              "count": 16433
            },
            {
              "scalar_value": 3,
              "count": 16854
            },
            {
              "scalar_value": 4,
              "count": 16598
            },
            {
              "scalar_value": 5,
              "count": 16676
            }
          ]
        },
        {
          "question": "They all returned from him to be seen: she found herself in the direction it pointed to, without trying to make it stop. 'Well, I'd hardly finished the goose, with the Queen shrieked out. 'Behead ?",
          "answers": [
            {
              "scalar_value": 0,
              "count": 16731
            },
            {
              "scalar_value": 1,
              "count": 16662
            },
            {
              "scalar_value": 2,
              "count": 16684
            },
            {
              "scalar_value": 3,
              "count": 16815
            },
            {
              "scalar_value": 4,
              "count": 16487
            },
            {
              "scalar_value": 5,
              "count": 16621
            }
          ]
        },
        {
          "question": "What would become of you? I gave her one, they gave him two, You gave us three or more; They all sat down again very sadly and quietly, and looked at Two. Two began in a low voice, 'Why the fact is ?",
          "answers": [
            {
              "scalar_value": 0,
              "count": 16669
            },
            {
              "scalar_value": 1,
              "count": 16580
            },
            {
              "scalar_value": 2,
              "count": 16888
            },
            {
              "scalar_value": 3,
              "count": 16484
            },
            {
              "scalar_value": 4,
              "count": 16652
            },
            {
              "scalar_value": 5,
              "count": 16727
            }
          ]
        },
        {
          "question": "Alice to herself, 'the way all the things I used to it in with a shiver. 'I beg pardon, your Majesty,' he began, 'for bringing these in: but I THINK I can reach the key; and if it began ordering ?",
          "answers": [
            {
              "scalar_value": 0,
              "count": 16618
            },
            {
              "scalar_value": 1,
              "count": 16574
            },
            {
              "scalar_value": 2,
              "count": 16717
            },
            {
              "scalar_value": 3,
              "count": 16725
            },
            {
              "scalar_value": 4,
              "count": 16542
            },
            {
              "scalar_value": 5,
              "count": 16824
            }
          ]
        },
        {
          "question": "LOVE). Oh dear, what nonsense I'm talking!' Just then her head was so long that they could not be denied, so she went back to the end of his great wig.' The judge, by the time he had to be ?",
          "answers": [
            {
              "scalar_value": 0,
              "count": 16671
            },
            {
              "scalar_value": 1,
              "count": 16700
            },
            {
              "scalar_value": 2,
              "count": 16815
            },
            {
              "scalar_value": 3,
              "count": 16553
            },
            {
              "scalar_value": 4,
              "count": 16656
            },
            {
              "scalar_value": 5,
              "count": 16605
            }
          ]
        },
        {
          "question": "Mock Turtle persisted. 'How COULD he turn them out of it, and talking over its head. 'Very uncomfortable for the hedgehogs; and in another moment, when she looked down at her as hard as it left no ?",
          "answers": [
            {
              "scalar_value": 0,
              "count": 16805
            },
            {
              "scalar_value": 1,
              "count": 16807
            },
            {
              "scalar_value": 2,
              "count": 16581
            },
            {
              "scalar_value": 3,
              "count": 16530
            },
            {
              "scalar_value": 4,
              "count": 16675
            },
            {
              "scalar_value": 5,
              "count": 16602
            }
          ]
        },
        {
          "question": "Alice, thinking it was only too glad to get her head on her toes when they hit her; and the two creatures, who had not got into a tree. By the use of repeating all that green stuff be?' said Alice ?",
          "answers": [
            {
              "scalar_value": 0,
              "count": 16539
            },
            {
              "scalar_value": 1,
              "count": 16560
            },
            {
              "scalar_value": 2,
              "count": 16921
            },
            {
              "scalar_value": 3,
              "count": 16683
            },
            {
              "scalar_value": 4,
              "count": 16751
            },
            {
              "scalar_value": 5,
              "count": 16546
            }
          ]
        },
        {
          "question": "Bill! I wouldn't be so proud as all that.' 'With extras?' asked the Gryphon, before Alice could hardly hear the rattle of the house till she had never seen such a pleasant temper, and thought it ?",
          "answers": [
            {
              "scalar_value": 0,
              "count": 16843
            },
            {
              "scalar_value": 1,
              "count": 16550
            },
            {
              "scalar_value": 2,
              "count": 16862
            },
            {
              "scalar_value": 3,
              "count": 16572
            },
            {
              "scalar_value": 4,
              "count": 16630
            },
            {
              "scalar_value": 5,
              "count": 16543
            }
          ]
        }
      ]
    },
    "free_answer_question": {
      "question_answers_count": 100000,
      "word_cloud": {
        "the": 189911,
        "to": 91671,
        "and": 90346
      }
    }
  }
}
```
