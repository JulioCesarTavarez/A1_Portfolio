board = [[1, 2, 3], [4, 5, 6], [7, 8, 9]]
def get_move(board, player):
    print(board)

def winner(board):
    if board[0][0] == "X" and board[1][1] == "X" and board[2][2] == "X":
        return "X"
    elif board[0][0] == "O" and board[1][1] == "O" and board[2][2] == "O":
        return "O"
    elif board[0][1] == "X" and board[1][1] == "X" and board[2][1] == "X":
        return "X"
    elif board[0][1] == "O" and board[1][1] == "O" and board[2][1] == "O":
        return "O"

    else:
        return None
def display_board(board):
    print("+-----+-----+-----+")

    for row in board:
        print()
        print("| ", end="")
        for cell in row:
            count = 0
            print(" " + str(cell) + "  | ", end="")
        print()    
        print("+-----+-----+-----+")



def main():

    print('Tic Tac Toe')

    display_board(board)

main()