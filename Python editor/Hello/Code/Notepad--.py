#-----------------------------------------------------
# Team Project Team H
# Members: Marcel Schilsky
#          Daryl Winslow
#          Adam Noonan
#          Stephen Pollard
#
# Submission Deadline: 22nd April 2015 8pm
#-----------------------------------------------------

#-----------------------------------------------------
#Library Imports
import tkinter as tk
import tkinter.font as tkfont
import tkinter
from tkinter import *
from tkinter.simpledialog import askstring
from tkinter.filedialog import asksaveasfilename
from tkinter.filedialog import askopenfilename
from tkinter.messagebox import askokcancel
import re, collections
#End of Library Imports
#-----------------------------------------------------

#-----------------------------------------------------
#Main Window Creation
root = Tk()
root.title("Notepad--")
w, h = root.winfo_screenwidth()-10, root.winfo_screenheight()
root.geometry("%dx%d+0+0" % (w, h))
root.focus_set() # <-- move focus to this widget
#End of Main Window Creation
#-----------------------------------------------------

#-----------------------------------------------------
#Fonts
StandardFont = tkfont.Font(family="courier", size=12)
Font1 = "helvetica"
Font2 = "times"
Font3 = "symbol"
Font4 = "verdana"
#End of Fonts
#-----------------------------------------------------

#-----------------------------------------------------
#Image Variables for Toolbar Icons
new = PhotoImage(file="images/new.png")
cut = PhotoImage(file="images/cut.png")
draw = PhotoImage(file="images/draw.png")
find = PhotoImage(file="images/find.png")
findandreplace = PhotoImage(file="images/findreplace.png")
fontsizedown = PhotoImage(file="images/fontsizedown.png")
fontsizeup = PhotoImage(file="images/fontsizeup.png")
openicon = PhotoImage(file="images/open.png")
paste = PhotoImage(file="images/paste.png")
save = PhotoImage(file="images/save.png")
wordcount = PhotoImage(file="images/wordcount.png")
#End of Image Variable declaration
#-----------------------------------------------------

#-----------------------------------------------------
#Widget Creation
sbar = Scrollbar(root)
toolbar = Frame(root, bg="lime green")
toolbar.pack(side=TOP, fill=X)
statusBar = Label(root, text="Word Count", bd=1, relief=SUNKEN, anchor=W)
statusBar.pack(side=BOTTOM, fill=Y)
text = Text(root, bg="light cyan", relief=SUNKEN, font=StandardFont)
sbar.config(command=text.yview)
text.config(yscrollcommand=sbar.set)
sbar.pack(side=RIGHT, fill=Y)
text.pack(side=LEFT, expand=YES, fill=BOTH)
root.text = text
#End of Widget Creation
#-----------------------------------------------------

#-----------------------------------------------------
#Functions
#onNew creates a new file after prompting the user to save the old file
def onNew():
    filename = asksaveasfilename()
    if filename:
        alltext = root.text.get('1.0', END+'-1c')
        open(filename, 'w').write(alltext)
        root.text.delete('1.0', END)

#changeFont1-4 are used to change the font in the text widget
def changeFont1():
    StandardFont.configure(family=Font1)

def changeFont2():
    StandardFont.configure(family=Font2)

def changeFont3():
    StandardFont.configure(family=Font3)

def changeFont4():
    StandardFont.configure(family=Font4)

#onBigger and onSmaller are used to change the size of the current font in the text widget
def onBigger():
    '''Make the font 2 points bigger'''
    size = StandardFont['size']
    StandardFont.configure(size=size+2)

def onSmaller():
    '''Make the font 2 points smaller'''
    size = StandardFont['size']
    if size>2:
        StandardFont.configure(size=size-2)
    else:
        root = tk.Tk()
        mainLabel = tk.Label(root, text = "Cant Make the Font Smaller")
        mainLabel.pack()
    
#onOpen ask the user to choose a file to open
def onOpen():
    Tk().withdraw()
    filename = askopenfilename()
    root.text.delete(1.0, END)
    root.text.insert(1.0, open(filename).read())

#onSave prompts the user to save the current progress to a file     
def onSave():
    filename = asksaveasfilename()
    if filename:
        alltext = root.text.get('1.0', END+'-1c')
        open(filename, 'w').write(alltext)

#onCut removes a selected portion of the text to the clipboard
def onCut():
    text = root.text.get(SEL_FIRST, SEL_LAST)
    root.text.delete(SEL_FIRST, SEL_LAST)
    root.clipboard_clear()
    root.clipboard_append(text)

#onPaste takes whatever is in the clipboard and paste it to the current cursor postion
def onPaste():
    try:
        text = root.selection_get(selection='CLIPBOARD')
        root.text.insert(INSERT, text)
    except TclError:
        pass
#quit asks the user to save the current progress to a file before exiting the program
def quit():
    filename = asksaveasfilename()
    if filename:
        alltext = root.text.get('1.0', END+'-1c')
        open(filename, 'w').write(alltext)
        ans = askokcancel('Verify exit', "Really quit?")
    if ans: root.quit(self)


#onFind will take in a String given by the User and will find the first instance of the word given in the text and highlight it.
#Bug: only finds the first instance of the target word within the text
def onFind():
    target = askstring('SimpleEditor', 'Search String?')
    if target:
        where = root.text.search(target, '1.0', END)
        if where:
            pastit = where + ('+%dc' % len(target))
            root.text.tag_remove(SEL, '1.0', END)
            root.text.tag_add(SEL, where, pastit)
            root.text.mark_set(INSERT, pastit)
            root.text.see(INSERT)
            root.text.focus()
            
#onReplace takes to in to Strings given by the user. The first is the target word or sentence to be replaced,
#and the second is the word that will replace the target word.
#Bug: only finds and replaces the first instance found within the text
def onReplace():
        target= askstring('Find','Word to be replaced:')
        replace = askstring('Replace','Replacing Word:')
        if target:
            where = root.text.search(target, '1.0', END)
            if where:
                pastit = where + ('+%dc' % len(target))
                root.text.tag_remove(SEL, '1.0', END)
                root.text.tag_add(SEL, where, pastit)
                root.text.mark_set(INSERT, pastit)
                root.text.see(INSERT)
                root.text.delete(SEL_FIRST, SEL_LAST)
                try:
                    root.text.insert(INSERT, replace)
                    root.text.replace(target, replace, 500)
                    root.text.focus()
                except TclError:
                    pass     

#EXTRA FEATURE
#onDraw opens a seprate window in which the user can draw shapes when clicking and holding the mouse and moving it over the canvas
def onDraw():
        canvas_width = 500
        canvas_height = 150

        def paint( event ):
           python_green = "#476042"
           x1, y1 = ( event.x - 1 ), ( event.y - 1 )
           x2, y2 = ( event.x + 1 ), ( event.y + 1 )
           w.create_oval( x1, y1, x2, y2, fill = python_green )

        draw = Tk()
        draw.title( "Draw Something Here" )
        w = Canvas(draw, width=canvas_width, height=canvas_height)
        w.pack(expand = YES, fill = BOTH)
        w.bind("<B1-Motion>", paint)

        message = Label( draw, text = "Press and Drag the mouse to draw" )
        message.pack( side = BOTTOM )
            
        mainloop()

#OnWordCount prompts the User to Save the current File progress to a file. Then uses the filename that was used to count the number of words, lines and characters
#and displays the imformation in a seprate window.
def onWordCount():
        num_lines = 0
        num_words = 0
        num_chars = 0
        filename = asksaveasfilename()
        if filename:
            alltext = text.get('1.0', END+'-1c')
            open(filename, 'w').write(alltext)
        with open(filename, 'r') as f:
            for line in f:
                words = line.split()

                num_lines += 1
                num_words += len(words)
                num_chars += len(line)

        count = tk.Tk()
        count.title( "Word Count" )
        mainLabel = tk.Label(count, text = "Word Count = "+str(num_words))
        mainLabel.pack()
        mainLabel2 = tk.Label(count, text = "Line Count = "+str(num_lines))
        mainLabel2.pack()
        mainLabel3 = tk.Label(count, text = "Character Count = "+str(num_chars))
        mainLabel3.pack()
#End of Function
#-----------------------------------------------------
            
#-----------------------------------------------------
#Drop Down Window Creation

#creates menubar to allow drop down menus
menu = Menu(root)
root.config(menu=menu)
subMenu = Menu(menu)

#creates first drop down menu called "File"
menu.add_cascade(label="File", menu=subMenu)
subMenu.add_command(label="New File", command=onNew)
subMenu.add_command(label="Save", command=onSave)
subMenu.add_command(label="Open", command=onOpen)
subMenu.add_separator()
subMenu.add_command(label="Quit", command=quit)

#creates drop down menu called "Edit"
editmenu = Menu(root)
menu.add_cascade(label="Edit", menu=editmenu)
editmenu.add_command(label="Cut", command=onCut)
editmenu.add_command(label="Paste", command=onPaste)
editmenu.add_command(label="Find", command=onFind)
editmenu.add_command(label="Replace", command=onReplace)
editmenu.add_separator()
editmenu.add_command(label="Increase Text Size", command=onBigger)
editmenu.add_command(label="Decrease Text Size", command=onSmaller)

#creates drop down menu called "Extras"
extramenu = Menu(root)
menu.add_cascade(label="Extras", menu=extramenu)
extramenu.add_command(label="Draw", command=onDraw)
extramenu.add_command(label="Word Count", command=onWordCount)

#creates drop down menu called "Fonts"
fontmenu = Menu(root)
menu.add_cascade(label="Fonts", menu=fontmenu)
fontmenu.add_command(label="Helvetica", command=changeFont1)
fontmenu.add_command(label="Times", command=changeFont2)
fontmenu.add_command(label="Symbol", command=changeFont3)
fontmenu.add_command(label="Verdana", command=changeFont4)
#End of Drop Down Menu Creation
#-----------------------------------------------------


#-----------------------------------------------------
#Toolbar Button Creation
openbutton = Button(toolbar, image=new, command=onNew)
openbutton.pack(side=LEFT)
openbutton = Button(toolbar, image=openicon, command=onOpen)
openbutton.pack(side=LEFT)
openbutton = Button(toolbar, image=save, command=onSave)
openbutton.pack(side=LEFT)
openbutton = Button(toolbar, image=cut, command=onCut)
openbutton.pack(side=LEFT)
openbutton = Button(toolbar, image=paste, command=onPaste)
openbutton.pack(side=LEFT)
openbutton = Button(toolbar, image=find, command=onFind)
openbutton.pack(side=LEFT)
openbutton = Button(toolbar, image=findandreplace, command=onReplace)
openbutton.pack(side=LEFT)
openbutton = Button(toolbar, image=fontsizeup, command=onBigger)
openbutton.pack(side=LEFT)
openbutton = Button(toolbar, image=fontsizedown, command=onSmaller)
openbutton.pack(side=LEFT)
openbutton = Button(toolbar, image=wordcount, command=onWordCount)
openbutton.pack(side=LEFT)
openbutton = Button(toolbar, image=draw, command=onDraw)
openbutton.pack(side=LEFT)
#End of Toolbar Button Creation
#-----------------------------------------------------

#-----------------------------------------------------
#Mainloop

root.mainloop()

#
#-----------------------------------------------------
