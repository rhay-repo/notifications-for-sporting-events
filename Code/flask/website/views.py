from flask import Blueprint, render_template, request, flash, jsonify
from flask_login import login_required, current_user
from . import db
from flask import Flask
import os
import json
from flask import Blueprint, render_template, request, flash, jsonify
from flask_login import login_required, current_user
from flask_mail import Mail, Message
from . import db
import json
import re
from datetime import datetime
import time

views = Blueprint('views', __name__)


@views.route('/', methods=['GET', 'POST'])
@login_required
def home():
    if request.method == 'POST':
        json_data = flask.request.json
        pass
    return render_template("home.html", user=current_user)


@views.route('/mail', methods=['POST'])
@login_required
def mail():
    mail = Mail()

    app = Flask(__name__)
    mail.init_app(app)
    if request.method == 'POST':
        cleaner = re.compile(r'<[^>]+>')
        dataTags = cleaner.sub(' ', request.data.decode('utf-8'))
        dataItems = dataTags.split('  ')
        day = dataItems[3]
        time = dataItems[4]
        dateString = day + ' ' + time
        dtObject = datetime.fromisoformat(dateString)
        unixTime = dtObject.timestamp()
        tableToPrint = request.data.decode('utf-8')
        tableToPrint = tableToPrint.split('<button')[0]
        msg = Message(subject='Your Game is about to start!', sender='clemson.sports.notifications@gmail.com', recipients=[current_user.email])
        msg.body = tableToPrint + '\n' + dataTags
        msg.extra_headers = {'X-SMTPAPI': json.dumps({'send_at': unixTime})}
        mail.send(msg)



    return render_template("home.html", user=current_user)
