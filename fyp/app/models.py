#from django.db import models
from django.contrib.gis.db import models

# Create your models here.
class SignUp(models.Model):
    email = models.EmailField()
    fullname = models.CharField(blank=True, null=True,max_length=50)
    timestamp = models.DateTimeField(auto_now_add=True, auto_now=False)#Time and date never changes

    def __unicode__(self):
        return self.email

class WeatherDetails(models.Model):
    location_name = models.CharField(max_length=30, null=True)
    lat = models.DecimalField(max_digits=9, decimal_places=6, null=True)
    long = models.DecimalField(max_digits=9, decimal_places=6, null=True)
    clo = models.IntegerField(null=True)
    temp = models.IntegerField(null=True)
    temp_min = models.IntegerField(null=True)
    temp_max = models.IntegerField(null=True)
    pressure = models.IntegerField(null=True)
    humidity = models.IntegerField(null=True)
    weather_details = models.CharField(max_length=40, null=True)
    description = models.CharField(max_length=100, null=True)
    wind_speed = models.FloatField(null=True)
    wind_degrees = models.FloatField(null=True)
    date_time = models.IntegerField(null=True)

    def __unicode__(self):
        return self.location_name

class Preferences(models.Model):
    place_name = models.CharField(max_length=50, null=True)
    description = models.CharField(max_length=200, null=True)
    date_created = models.DateTimeField(auto_now_add=True, auto_now=False)
    geom = models.PointField(srid=4326)

    def __unicode__(self):
        return self.name


