@core

Feature: Game

  Card

  Scenario: initialize card to start a new game
    Given An game with no card
    And two players "Tony" and "Fenley"
    Then The game can be started the cards are distributed

  Scenario Outline: multiple cards distribute one Winner
    Given I have  <cardOne> and <cardTwo>
    When I add <distribute> the first card to Tony and seconde one to Fenley
    Then then winner is <winnerIs>

  Examples:
    | cardOne | cardTwo | distribute        | winnerIs   |
    | (2,3)   | (3,2)   | ('Tony', 'Fenley')| 'Fenley'   |
    | (7,3)   | (5,3)   | ('Tony', 'Fenley')| 'Tony'     |
    | (6,3)   | (4,2)   | ('Tony', 'Fenley')| 'Tony'     |

  Scenario: the battle with gamers
    Given the following cards:
      | card  |
      |6,2  |
      |6,3  |
      |2,3  |
      |11,1 |
      |13,2 |
      |13,1 |
      |11,2 |
      |10,1 |
      |14,2 |
      |13,1 |

    Then the winner is Tony and total power is 99

  Scenario: the battle with two players and method run
    Given the following cards to run battle:
      | card  |
      |6,2  |
      |6,3  |
      |2,3  |
      |11,1 |
      |13,2 |
      |13,1 |
      |11,2 |
      |10,1 |
      |14,2 |
      |13,1 |
      |9,1 |
      |8,1 |
      |3,1 |
      |7,2 |
      |7,1 |
      |7,3 |
      |5,3 |
      |6,3 |

    Then the winner is Tony and total power is 116 and Fenley power is 10

  Scenario: distribute cards, the game ends when no more card
    Given the cards for two players
    When there are no cards the game stop the winner is one of two players