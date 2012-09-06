module.exports = (robot) ->

  robot.respond /wanchour repositor(ies|y)/i, (msg) ->
    try
      url = process.env.HUBOT_WANCHOUR_URL
      msg.http("#{url}/api/repositories")
        .get() (err, res, body) -> 
          try
            for repo in JSON.parse(body).repositories
              message = 'The repository "' + repo.id + '" is named "' + repo.name + '". its URL is ' + repo.url
              msg.send message
          catch e
            msg.send 'error : ' + e
    catch e
      msg.send 'error : ' + e

  robot.respond /wanchour distributions/i, (msg) ->
    try
      url = process.env.HUBOT_WANCHOUR_URL
      msg.http("#{url}/api/distributions")
        .get() (err, res, body) -> 
          try
            for distrib in JSON.parse(body).distributions
              msg.send 'Distribution "' + distrib.id + '" is named "' + distrib.name + '"'
              msg.send 'Parameters:'

              for name, value of distrib.parameters
                msg.send '  - name: ' + name + ' / value: ' + value   
          catch e
            msg.send 'error : ' + e
    catch e
      msg.send 'error : ' + e


  robot.respond /wanchour launch "([^\"]*)?" for "([^\"]*)?" with distribution "([^\"]*)?"/i, (msg) ->
    try
      url = process.env.HUBOT_WANCHOUR_URL
      command = msg.match[1]
      repo_name = msg.match[2]
      distribution_name = msg.match[3]
      repos = {}
      msg.http("#{url}/api/repositories")
        .get() (err, res, body) -> 
          try
            for repo in JSON.parse(body).repositories
              repos[repo.name] = repo.id

            if repos[repo_name]?
              distribs = {}
              msg.http("#{url}/api/distributions")
                .get() (err, res, body) -> 
                  try
                    for dist in JSON.parse(body).distributions
                      distribs[dist.name] = dist.id

                    if distribs[distribution_name]?
                      id = repos[repo_name]
                      id_distrib = distribs[distribution_name]
                      msg.http("#{url}/api/deploy/#{id}/#{command}/#{id_distrib}")
                        .get() (err, res, body) -> 
                          try
                            result = JSON.parse(body)
                            if result.status? and result.status == 'ok'
                              msg.send 'job "' + result.job_id + '" created'
                            else
                              msg.send 'error in the launch command'          
                          catch e
                            msg.send 'error : ' + e
                    else
                      msg.send 'error : The distribution ' + distribution_name + ' was not found.'
            else
              msg.send 'error : The repo ' + repo_name + ' was not found.'

          catch e
            msg.send 'error : ' + e

    catch e
      msg.send 'error : ' + e

  robot.respond /wanchour launch "([^\"]*)?" for "([^\"]*)?"/i, (msg) ->
    try
      url = process.env.HUBOT_WANCHOUR_URL
      command = msg.match[1]
      repo_name = msg.match[2]
      repos = {}
      msg.http("#{url}/api/repositories")
        .get() (err, res, body) -> 
          try
            for repo in JSON.parse(body).repositories
              repos[repo.name] = repo.id

            if repos[repo_name]?
              id = repos[repo_name]
              msg.http("#{url}/api/deploy/#{id}/#{command}")
                .get() (err, res, body) -> 
                  try
                    result = JSON.parse(body)
                    if result.status? and result.status == 'ok'
                      msg.send 'job "' + result.job_id + '" created'
                    else
                      msg.send 'error in the launch command'          
                  catch e
                    msg.send 'error : ' + e
            else
              msg.send 'error : The repo ' + repo_name + ' was not found.'

          catch e
            msg.send 'error : ' + e

    catch e
      msg.send 'error : ' + e


  robot.respond /wanchour job "(.*)?"/i, (msg) ->
    try
      url = process.env.HUBOT_WANCHOUR_URL
      job_id = msg.match[1]
      msg.http("#{url}/api/job/#{job_id}")
        .get() (err, res, body) -> 
          try
            result = JSON.parse(body)
            msg.send 'Job Status : "' + result.status
            msg.send 'Logs:'

            for log in result.logs
              msg.send ' - ' + log.priority + ' : ' + log.message   
          catch e
            msg.send 'error : ' + e
    catch e
      msg.send 'error : ' + e