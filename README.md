# Data binding

x-data init - object 
 
x-text accepts the key of x-data attribute and gives the value

On click you can change the value of the x-text of other element!
@click=message = 'Some new message'

You can add js functions(expressions)
x-text="message.toUpperCase().substr(1)"

:value - you bind the value from x-data to the input 

x-model - two way binding, as the input updates it updates the x-data key

# Toggle Visibility

- show = ! show
- ternary for x-text
-Button must be inside x-data div to work.
:class - conditional class like the object syntax, :class="{ 'active': currentTab === 'something' }"
- it doesnt need to be boolean you can assign a value to the object and then change it to show
ex. Tabs;

# Two way data binding

- x-model="value"
-We are binding the value to the input to what we have stored in the x-data object
and we are listening when the use creates an event(types into the input) and we update
the value stored in the x-data object
$event - magic variable that listens for the event that occur.
:value="name"
@input="name = $event.target.value" 
Is the same with x-model
in x-data add new object because its easier to submit the form and reference that new object
than adding all the properties.
use template when writing x-if x-for 

# How and when to extract component logic

- keep it inline as long as you can but extract it when it feels gross and its too much going on.
If you use a bundler make sure to add window. before the function because other way 
it wont be compiled.
- using modules export default () =>
Must then declare it:
import taskApp from ..
window.taskApp = taskApp;

# Transitions 

x-transition:enter
-start
-end
leave
leave-start
leave-end

#Events

we use flash.window to se the event globally not just form that div
$dispatch magic method accepts the name of the event and the value

