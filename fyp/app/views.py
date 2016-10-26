from django.shortcuts import render
from django.conf import settings
from django.core.mail import send_mail
from django.http import HttpResponse, HttpResponseRedirect
from django.core.context_processors import csrf
from django.contrib.gis.geos import Point
from .forms import *
from .models import *
import json, httplib2
import urllib.request

# Create your views here.
def home(request):
    """title = "Welcome"
    form = SignUpForm(request.POST or None)
    context ={
        "template_title": title,
        "form": form
    }

    if form.is_valid():
        instance = form.save(commit=True)
        instance.save
        context ={
            "template_title":"Thanks"
        }"""

    return render(request, 'home.html')

def contact(request):
    title = 'Contact Us'
    form = ContactForm(request.POST or None)
    if form.is_valid():
        form_email = form.cleaned_data.get('email')
        form_message = form.cleaned_data.get('message')
        form_full_name = form.cleaned_data.get('fullname')

        subject = 'Site contact form'
        from_email = settings.EMAIL_HOST_USER
        to_email = ['adamnoonan93@gmail.com']
        contact_message = "%s: %s via %s"%(
            form_full_name,
            form_message,
            form_email)


        send_mail(subject, contact_message, from_email, [to_email], fail_silently=False)
    context = {
        "form": form,
        "title": title,
    }
    return render(request, "forms.html", context)

def about(request):
    return render(request, "about.html")

def current_weather(request):

    """WeatherDetails.objects.filter(lat='53.350140', long='-6.266155')"""

    if request.GET is not None:
        with urllib.request.urlopen('http://api.openweathermap.org/data/2.5/box/city?bbox=-10,51,-5,55,10&cluster=yes&appid=49153ef926a23fa4514a045f1ea0fe87') as url:
            json_obj = url.read()
            decoded_data = json.loads(json_obj.decode('utf-8'))
    return render(request, "current_weather.html",
                  {'data': decoded_data})

def forecast_weather(request):
    return render(request, "forecast_weather.html")

def location(request):
    return render(request, "location.html")

def help(request):
    return render(request, "help.html")

def preference(request):
    if request.method == 'Post':
        form = PreferencesForm(request.POST)
        if form.is_valid():
            new_point = Preferences()
            cd = form.cleaned_data
            coordinates = cd['coordinates'].split(',')
            new_point.geom = Point(float(coordinates[0]), float(coordinates[1]))
            new_point.place_name = cd['place_name']
            new_point.description = cd['description']

            new_point.save()
            return HttpResponseRedirect('/preference/success')
        else:
            return HttpResponseRedirect('/preference/error')

    else:
        form = PreferencesForm()

    args = {}
    args.update(csrf(request))
    args['form'] = PreferencesForm()

    return render(request, 'preferences.html', args)

def form_error(request):
    return render(request, 'form_error.html')

def form_success(request):
    return render(request, 'form_success.html')