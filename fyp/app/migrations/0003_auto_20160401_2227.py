# -*- coding: utf-8 -*-
# Generated by Django 1.9.4 on 2016-04-01 21:27
from __future__ import unicode_literals

from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('app', '0002_preferences_weatherdetails'),
    ]

    operations = [
        migrations.RemoveField(
            model_name='preferences',
            name='name',
        ),
        migrations.AddField(
            model_name='preferences',
            name='description',
            field=models.CharField(max_length=200, null=True),
        ),
        migrations.AddField(
            model_name='preferences',
            name='place_name',
            field=models.CharField(max_length=50, null=True),
        ),
    ]
