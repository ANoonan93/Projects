from django.contrib import admin
from .models import *
from .forms import SignUpForm
from django.contrib.gis import admin


class SignUpAdmin(admin.ModelAdmin):
    list_display = ["__unicode__", "timestamp"]
    form = SignUpForm
    #class Meta:
        #model = SignUp

admin.site.register(SignUp, SignUpAdmin)
admin.site.register(Preferences, admin.OSMGeoAdmin)
